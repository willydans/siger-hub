<?php

// FILE: app/Http/Controllers/Api/AnalyticsController.php
// Analytics endpoints untuk admin dashboard
// Semua endpoint support filter periode: ?period=week | month | all (default: all)

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\SearchLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class AnalyticsController extends Controller
{
    use ApiResponse;

    // ── HELPER: date range dari period param ───────────────────────
    // period = week  → 7 hari terakhir
    // period = month → 30 hari terakhir
    // period = all   → semua waktu (default)
    private function getDateRange(string $period): ?string
    {
        return match ($period) {
            'week'  => now()->subDays(7)->toDateTimeString(),
            'month' => now()->subDays(30)->toDateTimeString(),
            default => null, // null = tidak ada filter waktu
        };
    }

    // ── GET /api/v1/admin/analytics/overview ──────────────────────
    // Ringkasan statistik utama untuk header dashboard admin
    public function overview(Request $request): JsonResponse
    {
        $period = $request->get('period', 'all');
        $since  = $this->getDateRange($period);

        $articleQuery = Article::query();
        $userQuery    = User::query();
        $viewQuery    = ArticleView::query();

        if ($since) {
            $articleQuery->where('created_at', '>=', $since);
            $userQuery->where('created_at', '>=', $since);
            $viewQuery->where('viewed_at', '>=', $since);
        }

        return $this->success([
            'period' => $period,

            // Artikel
            'articles' => [
                'total'     => (clone $articleQuery)->count(),
                'published' => (clone $articleQuery)->where('status', 'published')->count(),
                'pending'   => (clone $articleQuery)->where('status', 'pending')->count(),
                'draft'     => (clone $articleQuery)->where('status', 'draft')->count(),
                'revision'  => (clone $articleQuery)->where('status', 'revision')->count(),
                'rejected'  => (clone $articleQuery)->where('status', 'rejected')->count(),
            ],

            // Pengguna
            'users' => [
                'total'    => (clone $userQuery)->count(),
                'admin'    => User::role('admin')->count(), // role tidak berubah by periode
                'staff'    => User::role('staff')->count(),
                'user'     => User::role('user')->count(),
                'inactive' => User::where('is_active', false)->count(),
            ],

            // Engagement
            'engagement' => [
                'total_views'     => (clone $viewQuery)->count(),
                'total_downloads' => Article::sum('downloads_count'),
                'total_comments'  => DB::table('comments')->whereNull('deleted_at')->count(),
                'total_ratings'   => DB::table('ratings')->count(),
                'total_bookmarks' => DB::table('bookmarks')->count(),
            ],

            // Storage (estimasi dari attachments)
            'storage' => [
                'total_files'     => DB::table('attachments')->count(),
                'total_size_mb'   => round(DB::table('attachments')->sum('file_size') / 1048576, 2),
                'by_type'         => DB::table('attachments')
                    ->selectRaw('file_type, COUNT(*) as count, SUM(file_size) as total_size')
                    ->groupBy('file_type')
                    ->get()
                    ->map(fn ($r) => [
                        'type'       => $r->file_type,
                        'count'      => $r->count,
                        'size_mb'    => round($r->total_size / 1048576, 2),
                    ]),
            ],
        ]);
    }

    // ── GET /api/v1/admin/analytics/top-search ────────────────────
    // Keyword yang paling sering dicari
    public function topSearch(Request $request): JsonResponse
    {
        $period = $request->get('period', 'all');
        $since  = $this->getDateRange($period);
        $limit  = min((int) $request->get('limit', 10), 50);

        $query = SearchLog::selectRaw('keyword, COUNT(*) as search_count, AVG(result_count) as avg_results')
            ->groupBy('keyword')
            ->orderByDesc('search_count')
            ->limit($limit);

        if ($since) {
            $query->where('searched_at', '>=', $since);
        }

        $results = $query->get()->map(fn ($row) => [
            'keyword'      => $row->keyword,
            'search_count' => $row->search_count,
            'avg_results'  => round($row->avg_results, 1),
            'has_articles' => $row->avg_results > 0, // apakah pencarian ini menghasilkan artikel
        ]);

        return $this->success([
            'period' => $period,
            'items'  => $results,
        ]);
    }

    // ── GET /api/v1/admin/analytics/knowledge-gap ─────────────────
    // Keyword yang sering dicari tapi tidak menemukan artikel
    // Logic: keyword yang dicari >= 3 kali dan result_count = 0
    public function knowledgeGap(Request $request): JsonResponse
    {
        $period = $request->get('period', 'all');
        $since  = $this->getDateRange($period);
        $limit  = min((int) $request->get('limit', 15), 50);

        $query = SearchLog::selectRaw('keyword, COUNT(*) as search_count')
            ->where('result_count', 0)
            ->groupBy('keyword')
            ->having('search_count', '>=', 3) // dicari minimal 3 kali tapi tidak ada hasil
            ->orderByDesc('search_count')
            ->limit($limit);

        if ($since) {
            $query->where('searched_at', '>=', $since);
        }

        $gaps = $query->get()->map(fn ($row) => [
            'keyword'      => $row->keyword,
            'search_count' => $row->search_count,
            'priority'     => match (true) {
                $row->search_count >= 20 => 'high',
                $row->search_count >= 10 => 'medium',
                default                  => 'low',
            },
        ]);

        return $this->success([
            'period'      => $period,
            'total_gaps'  => $gaps->count(),
            'items'       => $gaps,
            'note'        => 'Keyword yang dicari minimal 3 kali namun tidak menghasilkan artikel.',
        ]);
    }

    // ── GET /api/v1/admin/analytics/top-contributors ──────────────
    // Staff dengan kontribusi artikel published terbanyak
    public function topContributors(Request $request): JsonResponse
    {
        $period = $request->get('period', 'all');
        $since  = $this->getDateRange($period);
        $limit  = min((int) $request->get('limit', 10), 50);

        $query = User::role('staff')
            ->withCount([
                'articles as published_count' => fn ($q) => $q->where('status', 'published'),
                'articles as total_count',
            ])
            ->with('opd:id,name')
            ->having('published_count', '>', 0)
            ->orderByDesc('published_count')
            ->limit($limit);

        if ($since) {
            $query->withCount([
                'articles as published_count' => fn ($q) => $q
                    ->where('status', 'published')
                    ->where('created_at', '>=', $since),
            ]);
        }

        $contributors = $query->get()->map(fn ($user) => [
            'id'              => $user->id,
            'name'            => $user->name,
            'avatar_url'      => $user->avatar_url,
            'opd'             => $user->opd?->name,
            'published_count' => $user->published_count,
            'total_count'     => $user->total_count,
        ]);

        return $this->success([
            'period' => $period,
            'items'  => $contributors,
        ]);
    }

    // ── GET /api/v1/admin/analytics/popular-articles ──────────────
    // Artikel paling banyak dilihat atau diunduh
    public function popularArticles(Request $request): JsonResponse
    {
        $period  = $request->get('period', 'all');
        $since   = $this->getDateRange($period);
        $sortBy  = $request->get('sort', 'views'); // views | downloads | rating
        $limit   = min((int) $request->get('limit', 10), 50);

        $query = Article::published()
            ->with(['author:id,name', 'category:id,name,color'])
            ->withAvg('ratings', 'value');

        if ($since) {
            // Filter berdasarkan artikel yang dibuat dalam periode ini
            $query->where('published_at', '>=', $since);
        }

        match ($sortBy) {
            'downloads' => $query->orderByDesc('downloads_count'),
            'rating'    => $query->orderByDesc('ratings_avg_value'),
            default     => $query->orderByDesc('views_count'),
        };

        $articles = $query->limit($limit)->get()->map(fn ($article) => [
            'id'             => $article->id,
            'title'          => $article->title,
            'slug'           => $article->slug,
            'author'         => $article->author?->name,
            'category'       => $article->category ? [
                'name'  => $article->category->name,
                'color' => $article->category->color,
            ] : null,
            'views_count'    => $article->views_count,
            'downloads_count'=> $article->downloads_count,
            'average_rating' => round($article->ratings_avg_value ?? 0, 1),
            'published_at'   => $article->published_at?->toDateString(),
        ]);

        return $this->success([
            'period'  => $period,
            'sort_by' => $sortBy,
            'items'   => $articles,
        ]);
    }

    // ── GET /api/v1/admin/analytics/views-chart ───────────────────
    // Data chart views harian untuk grafik di dashboard
    // Digunakan untuk render line chart per hari
    public function viewsChart(Request $request): JsonResponse
    {
        $period = $request->get('period', 'week');
        $days   = $period === 'month' ? 30 : 7;

        $data = ArticleView::selectRaw('DATE(viewed_at) as date, COUNT(*) as count')
            ->where('viewed_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Pastikan semua hari terisi (termasuk hari dengan 0 view)
        $chart = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chart[] = [
                'date'  => $date,
                'views' => $data[$date]->count ?? 0,
            ];
        }

        return $this->success([
            'period' => $period,
            'days'   => $days,
            'chart'  => $chart,
        ]);
    }
}