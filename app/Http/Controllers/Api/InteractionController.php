<?php

// FILE: app/Http/Controllers/Api/InteractionController.php
// Handle semua interaksi user terhadap artikel:
// Bookmark, Comment (+ reply + delete), Rating (updateOrCreate), History

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Resources\ArticleListResource;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Rating;
use App\Notifications\CommentReplyNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    use ApiResponse;

    // ══════════════════════════════════════════════════════════════
    // BOOKMARK
    // ══════════════════════════════════════════════════════════════

    // ── POST /api/v1/articles/{slug}/bookmark ──────────────────────
    // Toggle bookmark — kalau sudah ada hapus, kalau belum ada tambah
    public function toggleBookmark(Request $request, string $slug): JsonResponse
    {
        $article = Article::published()->where('slug', $slug)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        $user = $request->user();

        // Cek apakah sudah di-bookmark
        $isBookmarked = $article->bookmarkedByUsers()->where('user_id', $user->id)->exists();

        if ($isBookmarked) {
            $article->bookmarkedByUsers()->detach($user->id);
            return $this->success(['is_bookmarked' => false], 'Bookmark dihapus.');
        }

        $article->bookmarkedByUsers()->attach($user->id);
        return $this->success(['is_bookmarked' => true], 'Artikel berhasil di-bookmark.');
    }

    // ── GET /api/v1/user/bookmarks ─────────────────────────────────
    // List semua artikel yang sudah di-bookmark user yang login
    public function myBookmarks(Request $request): JsonResponse
    {
        $articles = $request->user()
            ->bookmarks()
            ->published()
            ->with(['author', 'category', 'tags'])
            ->latest('bookmarks.created_at')
            ->paginate($request->get('per_page', 10));

        return $this->success([
            'items'        => ArticleListResource::collection($articles->items()),
            'current_page' => $articles->currentPage(),
            'last_page'    => $articles->lastPage(),
            'total'        => $articles->total(),
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    // COMMENT
    // ══════════════════════════════════════════════════════════════

    // ── GET /api/v1/articles/{slug}/comments ───────────────────────
    // List komentar untuk artikel (public, tidak perlu login)
    public function getComments(Request $request, string $slug): JsonResponse
    {
        $article = Article::published()->where('slug', $slug)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        $comments = Comment::where('article_id', $article->id)
            ->whereNull('parent_id') // hanya komentar root (bukan reply)
            ->where('is_approved', true)
            ->with(['user', 'replies.user'])
            ->withCount('replies')
            ->latest()
            ->paginate($request->get('per_page', 10));

        return $this->success([
            'items'        => CommentResource::collection($comments->items()),
            'current_page' => $comments->currentPage(),
            'last_page'    => $comments->lastPage(),
            'total'        => $comments->total(),
        ]);
    }

    // ── POST /api/v1/articles/{slug}/comments ──────────────────────
    // Buat komentar baru atau reply komentar
    public function storeComment(StoreCommentRequest $request, string $slug): JsonResponse
    {
        $article = Article::published()->where('slug', $slug)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        $user = $request->user();

        // Kalau ada parent_id, ini adalah reply — validasi parent milik artikel ini
        if ($request->filled('parent_id')) {
            $parent = Comment::where('id', $request->parent_id)
                ->where('article_id', $article->id)
                ->whereNull('parent_id') // hanya bisa reply ke komentar root (1 level)
                ->first();

            if (!$parent) {
                return $this->notFound('Komentar yang ingin dibalas tidak ditemukan.');
            }
        }

        $comment = Comment::create([
            'user_id'    => $user->id,
            'article_id' => $article->id,
            'parent_id'  => $request->parent_id ?? null,
            'body'       => $request->body,
            'is_approved'=> true,
        ]);

        $comment->load('user');

        // Kirim notifikasi ke pemilik komentar asli kalau ini reply
        if ($request->filled('parent_id') && isset($parent)) {
            // Hanya kirim notif kalau yang reply bukan pemilik komentar itu sendiri
            if ($parent->user_id !== $user->id) {
                $parent->user->notify(new CommentReplyNotification($comment, $parent));
            }
        }

        return $this->created(
            new CommentResource($comment),
            $request->filled('parent_id') ? 'Balasan berhasil ditambahkan.' : 'Komentar berhasil ditambahkan.'
        );
    }

    // ── DELETE /api/v1/comments/{id} ───────────────────────────────
    // Hapus komentar — user bisa hapus milik sendiri, admin bisa hapus semua
    public function destroyComment(Request $request, int $id): JsonResponse
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return $this->notFound('Komentar tidak ditemukan.');
        }

        $user = $request->user();

        // User hanya bisa hapus komentar milik sendiri
        // Admin bisa hapus komentar siapa saja
        if ($comment->user_id !== $user->id && !$user->isAdmin()) {
            return $this->forbidden('Anda tidak memiliki izin menghapus komentar ini.');
        }

        // Soft delete — komentar masih ada di DB tapi tidak ditampilkan
        $comment->delete();

        return $this->success(null, 'Komentar berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════
    // RATING
    // ══════════════════════════════════════════════════════════════

    // ── POST /api/v1/articles/{slug}/rating ────────────────────────
    // Create atau update rating (updateOrCreate — tidak hapus, cukup update nilai)
    public function storeRating(StoreRatingRequest $request, string $slug): JsonResponse
    {
        $article = Article::published()->where('slug', $slug)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        $user = $request->user();

        // updateOrCreate: kalau sudah pernah rating → update value-nya
        //                 kalau belum pernah → insert baru
        $rating = Rating::updateOrCreate(
            [
                'user_id'    => $user->id,
                'article_id' => $article->id,
            ],
            [
                'value' => $request->value,
            ]
        );

        $wasRecentlyCreated = $rating->wasRecentlyCreated;

        return $this->success([
            'rating'         => $rating->value,
            'average_rating' => round($article->ratings()->avg('value'), 1),
            'total_ratings'  => $article->ratings()->count(),
        ], $wasRecentlyCreated ? 'Rating berhasil ditambahkan.' : 'Rating berhasil diperbarui.');
    }

    // ── DELETE /api/v1/articles/{slug}/rating ──────────────────────
    // Hapus rating user untuk artikel ini
    public function destroyRating(Request $request, string $slug): JsonResponse
    {
        $article = Article::published()->where('slug', $slug)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        $deleted = Rating::where('user_id', $request->user()->id)
            ->where('article_id', $article->id)
            ->delete();

        if (!$deleted) {
            return $this->error('Anda belum memberikan rating untuk artikel ini.', 404);
        }

        return $this->success([
            'average_rating' => round($article->ratings()->avg('value'), 1),
            'total_ratings'  => $article->ratings()->count(),
        ], 'Rating berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════════
    // HISTORY & NOTIFIKASI
    // ══════════════════════════════════════════════════════════════

    // ── GET /api/v1/user/history ───────────────────────────────────
    // Riwayat artikel yang pernah dibaca user yang login
    public function myHistory(Request $request)
{
    // 1. Ambil ID artikel yang unik, diurutkan dari waktu baca paling terakhir (MAX)
    $articleIds = \Illuminate\Support\Facades\DB::table('article_views')
        ->selectRaw('article_id, MAX(viewed_at) as last_viewed')
        ->where('user_id', $request->user()->id)
        ->groupBy('article_id')
        ->orderBy('last_viewed', 'desc')
        ->limit(50)
        ->pluck('article_id');

    // 2. Ambil data artikelnya berdasarkan ID tersebut
    $articles = \App\Models\Article::with(['category', 'author']) // Sesuaikan relasi jika perlu
        ->whereIn('id', $articleIds)
        ->get()
        // 3. Urutkan kembali hasil query agar sesuai dengan urutan history (last_viewed)
        ->sortBy(function ($article) use ($articleIds) {
            return array_search($article->id, $articleIds->toArray());
        })
        ->values();

    // Sesuaikan dengan format response kamu (contoh jika pakai Resource)
    return $this->success(
        \App\Http\Resources\ArticleListResource::collection($articles),
        'Riwayat baca berhasil diambil.'
    );
}

    // ── GET /api/v1/user/notifications ────────────────────────────
    // List notifikasi user yang login
    public function myNotifications(Request $request): JsonResponse
    {
        $user = $request->user();

        $notifications = $user->notifications()
            ->latest()
            ->paginate($request->get('per_page', 15));

        return $this->success([
            'items' => $notifications->map(fn ($n) => [
                'id'        => $n->id,
                'type'      => $n->data['type'] ?? null,
                'message'   => $n->data['message'] ?? null,
                'data'      => $n->data,
                'read_at'   => $n->read_at?->toDateTimeString(),
                'created_at'=> $n->created_at->toDateTimeString(),
            ]),
            'unread_count' => $user->unreadNotifications()->count(),
            'current_page' => $notifications->currentPage(),
            'last_page'    => $notifications->lastPage(),
            'total'        => $notifications->total(),
        ]);
    }

    // ── PUT /api/v1/user/notifications/{id}/read ──────────────────
    // Tandai 1 notifikasi sebagai sudah dibaca
    public function markNotificationRead(Request $request, string $id): JsonResponse
    {
        $notification = $request->user()->notifications()->find($id);

        if (!$notification) {
            return $this->notFound('Notifikasi tidak ditemukan.');
        }

        $notification->markAsRead();

        return $this->success(null, 'Notifikasi ditandai sudah dibaca.');
    }

    // ── PUT /api/v1/user/notifications/read-all ───────────────────
    // Tandai semua notifikasi sebagai sudah dibaca
    public function markAllNotificationsRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return $this->success(null, 'Semua notifikasi ditandai sudah dibaca.');
    }
}