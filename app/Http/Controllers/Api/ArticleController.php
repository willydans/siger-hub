<?php

// FILE: app/Http/Controllers/Api/ArticleController.php
// Endpoint PUBLIC — bisa diakses guest maupun user login

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleListResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\SearchLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use ApiResponse;

    // ── GET /api/v1/articles ───────────────────────────────────────
    // List artikel published + public. Support filter & search.
    public function index(Request $request): JsonResponse
    {
        $query = Article::query()
            ->published()
            ->with(['author', 'category', 'tags'])
            ->withCount('comments');

        // Guest hanya boleh lihat visibility=public
        // User yang login boleh lihat public + restricted
        $user = $request->user(); // null kalau guest (token tidak ada/invalid tapi route tetap publik)
        if ($user) {
            $query->whereIn('visibility', ['public', 'restricted']);
        } else {
            $query->where('visibility', 'public');
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        // Filter tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $request->tag));
        }

        // Filter OPD
        if ($request->filled('opd')) {
            $query->whereHas('opd', fn ($q) => $q->where('slug', $request->opd));
        }

        // Search (full-text)
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->search($keyword);

            // Catat ke search_logs untuk analytics & knowledge gap
            SearchLog::create([
                'user_id'      => $user?->id,
                'keyword'      => $keyword,
                'result_count' => $query->count(),
                'ip_address'   => $request->ip(),
                'searched_at'  => now(),
            ]);
        }

        // Sorting
        $sort = $request->get('sort', 'latest'); // latest | popular | rating
        match ($sort) {
            'popular' => $query->orderByDesc('views_count'),
            'rating'  => $query->orderByDesc(
                Article::select('value')
                    ->selectRaw('AVG(value)')
                    ->whereColumn('article_id', 'articles.id')
            ),
            default   => $query->latest('published_at'),
        };

        $perPage  = min((int) $request->get('per_page', 12), 50); // cap max 50 per page
        $articles = $query->paginate($perPage);

        return $this->success([
            'items'        => ArticleListResource::collection($articles->items()),
            'current_page' => $articles->currentPage(),
            'last_page'    => $articles->lastPage(),
            'per_page'     => $articles->perPage(),
            'total'        => $articles->total(),
        ]);
    }

    // ── GET /api/v1/articles/popular ───────────────────────────────
    public function popular(Request $request): JsonResponse
    {
        $articles = Article::published()
            ->where('visibility', 'public')
            ->with(['author', 'category'])
            ->orderByDesc('views_count')
            ->limit($request->get('limit', 5))
            ->get();

        return $this->success(ArticleListResource::collection($articles));
    }

    // ── GET /api/v1/articles/recent ────────────────────────────────
    public function recent(Request $request): JsonResponse
    {
        $articles = Article::published()
            ->where('visibility', 'public')
            ->with(['author', 'category'])
            ->latest('published_at')
            ->limit($request->get('limit', 5))
            ->get();

        return $this->success(ArticleListResource::collection($articles));
    }

    // ── GET /api/v1/articles/{slug} ────────────────────────────────
    public function show(Request $request, string $slug): JsonResponse
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->with(['author', 'category', 'opd', 'tags', 'attachments'])
            ->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        $user = $request->user();

        // Cek hak akses berdasarkan visibility
        if ($article->visibility === 'restricted' && !$user) {
            return $this->forbidden('Artikel ini hanya bisa diakses oleh pengguna yang login.');
        }

        if ($article->visibility === 'private') {
            // Private hanya untuk penulis & admin
            if (!$user || ($user->id !== $article->user_id && !$user->isAdmin())) {
                return $this->forbidden('Anda tidak memiliki akses ke artikel ini.');
            }
        }

        // Catat view history (hanya 1x per session sederhana — production bisa pakai cache/cooldown)
        $article->incrementView();
        $article->views()->create([
            'user_id'    => $user?->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'viewed_at'  => now(),
        ]);

        // Tandai apakah user yang login sudah bookmark artikel ini
        if ($user) {
            $article->is_bookmarked = $article->bookmarkedByUsers()->where('user_id', $user->id)->exists();
        }

        return $this->success(new ArticleResource($article));
    }
}