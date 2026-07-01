<?php

// FILE: app/Http/Controllers/Api/AdminArticleController.php
// Endpoint khusus ADMIN — approval workflow, monitoring, version rollback

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleListResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\User;
use App\Notifications\ArticleApprovedNotification;
use App\Notifications\ArticleRejectedNotification;
use App\Notifications\ArticleRevisionNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{
    use ApiResponse;

    // ── GET /api/v1/admin/articles/pending ─────────────────────────
    // List semua artikel yang menunggu approval
    public function pending(Request $request): JsonResponse
    {
        $articles = Article::where('status', 'pending')
            ->with(['author.opd', 'category', 'tags'])
            ->latest('updated_at')
            ->paginate($request->get('per_page', 10));

        return $this->success([
            'items'        => ArticleListResource::collection($articles->items()),
            'current_page' => $articles->currentPage(),
            'last_page'    => $articles->lastPage(),
            'total'        => $articles->total(),
        ]);
    }

    // ── GET /api/v1/admin/articles ─────────────────────────────────
    // List SEMUA artikel (semua status, termasuk draft, rejected, dll)
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['author', 'category', 'opd'])
            ->withTrashed(); // termasuk yang sudah di-archive (soft delete)

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter OPD
        if ($request->filled('opd_id')) {
            $query->where('opd_id', $request->opd_id);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $articles = $query->latest()->paginate($request->get('per_page', 15));

        return $this->success([
            'items'        => ArticleListResource::collection($articles->items()),
            'current_page' => $articles->currentPage(),
            'last_page'    => $articles->lastPage(),
            'total'        => $articles->total(),
        ]);
    }

    // ── GET /api/v1/admin/articles/{id} ────────────────────────────
    // Detail artikel untuk di-review admin (dengan semua relasi & version history)
    public function show(int $id): JsonResponse
    {
        $article = Article::withTrashed()
            ->with(['author', 'category', 'opd', 'tags', 'attachments', 'revisions.reviewer', 'versions'])
            ->find($id);

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        return $this->success(new ArticleResource($article));
    }

    // ── POST /api/v1/admin/articles/{id}/approve ───────────────────
    // Approve artikel → langsung published
    public function approve(Request $request, int $id): JsonResponse
    {
        $article = Article::where('status', 'pending')->find($id);

        if (!$article) {
            return $this->notFound('Artikel pending tidak ditemukan.');
        }

        $article->update([
            'status'       => 'published',
            'published_at' => now(),
        ]);

        // Kirim notifikasi ke staff penulis
        $article->author->notify(new ArticleApprovedNotification($article));

        activity()
            ->causedBy($request->user())
            ->performedOn($article)
            ->withProperties(['action' => 'approve'])
            ->log('approve_article');

        return $this->success(
            new ArticleResource($article->fresh(['author', 'category'])),
            'Artikel berhasil disetujui dan dipublikasikan.'
        );
    }

    // ── POST /api/v1/admin/articles/{id}/revision ──────────────────
    // Minta revisi ke staff dengan catatan detail
    public function revision(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'notes'    => ['required', 'string'],
            'section'  => ['nullable', 'string', 'max:255'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'deadline' => ['nullable', 'date', 'after:today'],
        ]);

        $article = Article::where('status', 'pending')->find($id);

        if (!$article) {
            return $this->notFound('Artikel pending tidak ditemukan.');
        }

        // Simpan catatan revisi
        $revision = ArticleRevision::create([
            'article_id'  => $article->id,
            'reviewed_by' => $request->user()->id,
            'section'     => $request->section,
            'priority'    => $request->priority ?? 'medium',
            'deadline'    => $request->deadline,
            'notes'       => $request->notes,
            'status'      => 'open',
        ]);

        // Kembalikan status artikel ke 'revision'
        $article->update(['status' => 'revision']);

        // Kirim notifikasi ke staff penulis
        $article->author->notify(new ArticleRevisionNotification($article, $revision));

        activity()
            ->causedBy($request->user())
            ->performedOn($article)
            ->withProperties(['revision_id' => $revision->id, 'notes' => $request->notes])
            ->log('request_revision');

        return $this->success([
            'article'  => new ArticleResource($article->fresh()),
            'revision' => [
                'id'       => $revision->id,
                'section'  => $revision->section,
                'priority' => $revision->priority,
                'deadline' => $revision->deadline?->toDateString(),
                'notes'    => $revision->notes,
            ],
        ], 'Permintaan revisi berhasil dikirim ke penulis.');
    }

    // ── POST /api/v1/admin/articles/{id}/reject ────────────────────
    // Tolak artikel secara permanen
    public function reject(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $article = Article::where('status', 'pending')->find($id);

        if (!$article) {
            return $this->notFound('Artikel pending tidak ditemukan.');
        }

        $article->update(['status' => 'rejected']);

        // Kirim notifikasi ke staff penulis
        $article->author->notify(new ArticleRejectedNotification($article, $request->reason));

        activity()
            ->causedBy($request->user())
            ->performedOn($article)
            ->withProperties(['reason' => $request->reason])
            ->log('reject_article');

        return $this->success(
            new ArticleResource($article->fresh()),
            'Artikel berhasil ditolak.'
        );
    }

    // ── PUT /api/v1/admin/articles/{id}/archive ────────────────────
    // Archive artikel published (soft delete — masih bisa di-restore)
    public function archive(Request $request, int $id): JsonResponse
    {
        $article = Article::where('status', 'published')->find($id);

        if (!$article) {
            return $this->notFound('Artikel published tidak ditemukan.');
        }

        $article->delete(); // soft delete karena model pakai SoftDeletes

        activity()
            ->causedBy($request->user())
            ->performedOn($article)
            ->log('archive_article');

        return $this->success(null, 'Artikel berhasil diarsipkan.');
    }

    // ── POST /api/v1/admin/articles/{id}/restore ───────────────────
    // Restore artikel yang sudah diarsipkan
    public function restore(Request $request, int $id): JsonResponse
    {
        $article = Article::onlyTrashed()->find($id);

        if (!$article) {
            return $this->notFound('Artikel arsip tidak ditemukan.');
        }

        $article->restore();

        activity()
            ->causedBy($request->user())
            ->performedOn($article)
            ->log('restore_article');

        return $this->success(
            new ArticleResource($article->fresh()),
            'Artikel berhasil dipulihkan.'
        );
    }

    // ── DELETE /api/v1/admin/articles/{id} ─────────────────────────
    // Hapus permanen (force delete — tidak bisa di-restore)
    public function destroy(Request $request, int $id): JsonResponse
    {
        $article = Article::withTrashed()->find($id);

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        // Hapus thumbnail fisik
        if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->forceDelete();

        activity()
            ->causedBy($request->user())
            ->withProperties(['article_title' => $article->title])
            ->log('force_delete_article');

        return $this->success(null, 'Artikel berhasil dihapus permanen.');
    }

    // ── POST /api/v1/admin/articles/{id}/rollback ──────────────────
    // Rollback artikel ke versi sebelumnya
    public function rollback(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'version_id' => ['required', 'integer', 'exists:article_versions,id'],
        ]);

        $article = Article::find($id);

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        $version = $article->versions()->find($request->version_id);

        if (!$version) {
            return $this->notFound('Versi tidak ditemukan untuk artikel ini.');
        }

        $snapshot = $version->snapshot;

        // Restore konten dari snapshot
        $article->update([
            'title'       => $snapshot['title'],
            'content'     => $snapshot['content'],
            'thumbnail'   => $snapshot['thumbnail'] ?? $article->thumbnail,
            'category_id' => $snapshot['category_id'] ?? $article->category_id,
        ]);

        // Sync tags dari snapshot
        if (!empty($snapshot['tags'])) {
            $tagIds = \App\Models\Tag::whereIn('name', $snapshot['tags'])->pluck('id');
            $article->tags()->sync($tagIds);
        }

        activity()
            ->causedBy($request->user())
            ->performedOn($article)
            ->withProperties(['rolled_back_to_version' => $version->version_number])
            ->log('rollback_article');

        return $this->success(
            new ArticleResource($article->fresh(['category', 'tags'])),
            'Artikel berhasil di-rollback ke versi ' . $version->version_number . '.'
        );
    }
}