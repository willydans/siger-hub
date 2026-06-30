<?php

// FILE: app/Http/Controllers/Api/StaffArticleController.php
// Endpoint khusus STAFF — kelola artikel milik sendiri (draft → submit → pending)

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\ArticleListResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StaffArticleController extends Controller
{
    use ApiResponse;

    // ── GET /api/v1/staff/articles ─────────────────────────────────
    // List semua artikel milik staff yang login, bisa difilter by status
    public function index(Request $request): JsonResponse
    {
        $query = Article::query()
            ->where('user_id', $request->user()->id)
            ->with(['category', 'tags'])
            ->withCount('comments');

        if ($request->filled('status')) {
            // status: draft | pending | published | revision | rejected
            $query->where('status', $request->status);
        }

        $articles = $query->latest()->paginate($request->get('per_page', 10));

        return $this->success([
            'items'        => ArticleListResource::collection($articles->items()),
            'current_page' => $articles->currentPage(),
            'last_page'    => $articles->lastPage(),
            'total'        => $articles->total(),
        ]);
    }

    // ── GET /api/v1/staff/articles/{id} ────────────────────────────
    // Detail artikel milik sendiri (termasuk draft, revision notes, dll)
    public function show(Request $request, int $id): JsonResponse
    {
        $article = Article::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['category', 'opd', 'tags', 'attachments', 'revisions', 'versions'])
            ->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan atau bukan milik Anda.');
        }

        return $this->success(new ArticleResource($article));
    }

    // ── POST /api/v1/staff/articles ────────────────────────────────
    // Buat artikel baru → otomatis status = draft
    public function store(StoreArticleRequest $request): JsonResponse
    {
        $user = $request->user();

        $slug = $this->generateUniqueSlug($request->title);

        $data = $request->only([
            'title', 'category_id', 'content', 'visibility',
            'meta_title', 'meta_description', 'keywords', 'references',
        ]);

        $data['user_id'] = $user->id;
        $data['opd_id']  = $user->opd_id;
        $data['slug']    = $slug;
        $data['status']  = 'draft';
        $data['version'] = 1;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article = Article::create($data);

        // Sinkronkan tags (firstOrCreate berdasarkan nama)
        if ($request->filled('tags')) {
            $this->syncTags($article, $request->tags);
        }

        // Simpan snapshot versi pertama
        $this->saveVersionSnapshot($article, $user->id, 'Draft awal dibuat');

        activity()->causedBy($user)->performedOn($article)->log('create_article');

        return $this->created(new ArticleResource($article->load(['category', 'tags'])), 'Artikel berhasil dibuat sebagai draft.');
    }

    // ── PUT /api/v1/staff/articles/{id} ────────────────────────────
    // Edit artikel — hanya bisa kalau status masih draft atau revision
    public function update(UpdateArticleRequest $request, int $id): JsonResponse
    {
        $user    = $request->user();
        $article = Article::where('id', $id)->where('user_id', $user->id)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan atau bukan milik Anda.');
        }

        if (!in_array($article->status, ['draft', 'revision'])) {
            return $this->forbidden('Artikel dengan status "' . $article->status . '" tidak bisa diedit.');
        }

        $data = $request->only([
            'title', 'category_id', 'content', 'visibility',
            'meta_title', 'meta_description', 'keywords', 'references',
        ]);

        // Kalau judul berubah, regenerate slug
        if ($request->filled('title') && $request->title !== $article->title) {
            $data['slug'] = $this->generateUniqueSlug($request->title, $article->id);
        }

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update($data);

        if ($request->has('tags')) {
            $this->syncTags($article, $request->tags);
        }

        activity()->causedBy($user)->performedOn($article)->log('update_article');

        return $this->success(new ArticleResource($article->fresh(['category', 'tags'])), 'Artikel berhasil diperbarui.');
    }

    // ── DELETE /api/v1/staff/articles/{id} ─────────────────────────
    // Hapus artikel — hanya draft yang boleh dihapus staff sendiri
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user    = $request->user();
        $article = Article::where('id', $id)->where('user_id', $user->id)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan atau bukan milik Anda.');
        }

        if ($article->status !== 'draft') {
            return $this->forbidden('Hanya artikel berstatus draft yang bisa dihapus.');
        }

        // Hapus thumbnail fisik
        if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        activity()->causedBy($user)->log('delete_article');

        return $this->success(null, 'Artikel berhasil dihapus.');
    }

    // ── POST /api/v1/staff/articles/{id}/submit ────────────────────
    // Submit draft → pending approval (validasi kelengkapan dulu)
    public function submit(Request $request, int $id): JsonResponse
    {
        $user    = $request->user();
        $article = Article::where('id', $id)->where('user_id', $user->id)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan atau bukan milik Anda.');
        }

        if (!in_array($article->status, ['draft', 'revision'])) {
            return $this->forbidden('Artikel dengan status "' . $article->status . '" tidak bisa disubmit.');
        }

        // Validasi kelengkapan sebelum submit
        $missing = [];
        if (empty($article->title))       $missing[] = 'judul';
        if (empty($article->category_id)) $missing[] = 'kategori';
        if (empty($article->thumbnail))   $missing[] = 'thumbnail';
        if (empty($article->content))     $missing[] = 'isi artikel';

        if (!empty($missing)) {
            return $this->error('Artikel belum lengkap. Mohon lengkapi: ' . implode(', ', $missing), 422);
        }

        $wasRevision = $article->status === 'revision';

        $article->update(['status' => 'pending']);

        // Tandai revision lama sebagai resolved (kalau ini submit ulang setelah revisi)
        if ($wasRevision) {
            $article->revisions()->where('status', 'open')->update(['status' => 'resolved']);
        }

        // Simpan snapshot versi baru
        $article->increment('version');
        $this->saveVersionSnapshot($article, $user->id, $wasRevision ? 'Submit ulang setelah revisi' : 'Submit untuk approval');

        activity()->causedBy($user)->performedOn($article)->log('submit_article');

        // TODO Step 4: trigger notifikasi ke semua admin

        return $this->success(new ArticleResource($article->fresh()), 'Artikel berhasil disubmit, menunggu persetujuan admin.');
    }

    // ── HELPERS ──────────────────────────────────────────────────────

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug     = Str::slug($title);
        $original = $slug;
        $i        = 1;

        while (Article::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    private function syncTags(Article $article, array $tagNames): void
    {
        $tagIds = [];
        foreach ($tagNames as $name) {
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
            $tagIds[] = $tag->id;
        }
        $article->tags()->sync($tagIds);
    }

    private function saveVersionSnapshot(Article $article, int $userId, string $summary): void
    {
        $article->versions()->create([
            'created_by'     => $userId,
            'version_number' => $article->version,
            'snapshot'       => [
                'title'       => $article->title,
                'content'     => $article->content,
                'thumbnail'   => $article->thumbnail,
                'category_id' => $article->category_id,
                'tags'        => $article->tags->pluck('name'),
            ],
            'change_summary' => $summary,
        ]);
    }
}