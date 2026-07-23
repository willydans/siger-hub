<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Feedback;
use App\Models\SearchLog;
use App\Models\UserActivity;
use App\Models\User;
use App\Models\Bookmark; 
use App\Models\Comment;  
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

        // --- Statistik Kartu (Dinamis dari Database) ---
        $stats = [
            'views'       => Article::sum('views'),
            'downloads'   => Article::sum('downloads'),
            'bookmarks'   => Bookmark::count(), // ✅ Dinamis dari tabel bookmarks
            'comments'    => Comment::count(), // ✅ Dinamis dari tabel comments
            'rating'      => round(Article::get()->avg('rating_avg'), 1) ?: 0,
            'feedback'    => Feedback::count(),
            'keyword'     => SearchLog::count(),
            'active_users'=> UserActivity::whereBetween('created_at', [$start, $end])
                            ->whereNotNull('user_id') // ✅ Hanya user yang login
                            ->distinct('user_id')
                            ->count(),
        ];

        // --- Heatmap (Aktivitas per jam) ---
        $hourlyData = $this->getHourlyActivity($start, $end);

        // --- Top Search (Mengelompokkan query berdasarkan jumlah pencarian terbanyak) ---
        $topSearches = SearchLog::select('query', DB::raw('count(*) as total'))
                    ->groupBy('query')
                    ->orderBy('total', 'desc')
                    ->limit(4)
                    ->get();

        // --- Knowledge Gap (Query yang sering dicari tapi tidak ada artikel yang membahasnya) ---
        $knowledgeGaps = $this->getKnowledgeGaps($topSearches, 3);

        return view('admin-analytics', compact('stats', 'hourlyData', 'topSearches', 'knowledgeGaps', 'filter'));
    }

    /**
     * Helper untuk menentukan rentang tanggal berdasarkan filter.
     */
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

    /**
     * Helper untuk mendapatkan data aktivitas per jam (0-23).
     */
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
     * Mendapatkan gap pengetahuan dari top search dengan mengecek judul DAN konten artikel.
     */
    private function getKnowledgeGaps($topSearches, $limit = 3)
    {
        $gaps = [];
        foreach ($topSearches as $search) {
            // ✅ Cek apakah ada artikel dengan judul ATAU konten yang mengandung kata kunci query
            $articleCount = Article::where('title', 'like', '%' . $search->query . '%')
                           ->orWhere('content', 'like', '%' . $search->query . '%')
                           ->count();

            if ($articleCount == 0) {
                $gaps[] = [
                    'keyword' => $search->query,
                    'searches' => $search->total,
                ];
            }
            if (count($gaps) >= $limit) break;
        }

        // ✅ Kembalikan array kosong jika tidak ada gap, view akan menanganinya dengan @empty
        return $gaps;
    }
}