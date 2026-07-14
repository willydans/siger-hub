<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Feedback;
use App\Models\SearchLog;
use App\Models\UserActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'today');
        $dateRange = $this->getDateRange($filter);
        $start = $dateRange['start'];
        $end   = $dateRange['end'];

        // --- Statistik Kartu ---
        $stats = [
            'views'       => Article::sum('views'),
            'downloads'   => Article::sum('downloads'),
            'bookmarks'   => 0, // Sesuaikan jika ada model Bookmark
            'comments'    => Article::sum('comments_count'),
            'rating'      => round(Article::avg('rating_avg'), 1),
            'feedback'    => Feedback::count(),
            'keyword'     => SearchLog::count(), // Total pencarian
            'active_users'=> UserActivity::whereBetween('created_at', [$start, $end])->distinct('user_id')->count(),
        ];

        // --- Heatmap (Aktivitas per jam) ---
        $hourlyData = $this->getHourlyActivity($start, $end);

        // --- Top Search (Mengelompokkan query berdasarkan jumlah pencarian terbanyak) ---
        $topSearches = SearchLog::select('query', DB::raw('count(*) as total'))
                    ->groupBy('query')
                    ->orderBy('total', 'desc')
                    ->limit(4)
                    ->get();

        // --- Knowledge Gap (Query yang sering dicari tapi tidak ada artikel dengan judul mirip) ---
        $knowledgeGaps = $this->getKnowledgeGaps($topSearches, 3);

        return view('admin-analytics', compact('stats', 'hourlyData', 'topSearches', 'knowledgeGaps', 'filter'));
    }

    private function getDateRange($filter)
    {
        $now = Carbon::now();
        switch ($filter) {
            case 'week':
                return ['start' => $now->copy()->startOfWeek(), 'end' => $now->copy()->endOfWeek()];
            case 'month':
                return ['start' => $now->copy()->startOfMonth(), 'end' => $now->copy()->endOfMonth()];
            case 'year':
                return ['start' => $now->copy()->startOfYear(), 'end' => $now->copy()->endOfYear()];
            default: // today
                return ['start' => $now->copy()->startOfDay(), 'end' => $now->copy()->endOfDay()];
        }
    }

    private function getHourlyActivity($start, $end)
    {
        $data = array_fill(0, 24, 0);
        $activities = UserActivity::selectRaw('HOUR(created_at) as hour, COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        foreach ($activities as $hour => $count) {
            $data[$hour] = $count;
        }
        return $data;
    }

    /**
     * Mendapatkan gap pengetahuan dari top search
     */
    private function getKnowledgeGaps($topSearches, $limit = 3)
    {
        $gaps = [];
        foreach ($topSearches as $search) {
            // Cek apakah ada artikel dengan judul yang mengandung kata kunci query
            $articleCount = Article::where('title', 'like', '%' . $search->query . '%')->count();
            if ($articleCount == 0) {
                $gaps[] = [
                    'keyword' => $search->query,
                    'searches' => $search->total,
                ];
            }
            if (count($gaps) >= $limit) break;
        }

        // Jika masih kurang, isi dengan dummy
        while (count($gaps) < $limit) {
            $gaps[] = [
                'keyword' => 'Contoh Gap ' . (count($gaps)+1),
                'searches' => 0,
            ];
        }

        return $gaps;
    }
}