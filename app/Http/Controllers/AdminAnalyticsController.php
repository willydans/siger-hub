<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalyticsLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        // 1. Data aktual dari tabel analytics_logs
        $rawViewCount = AnalyticsLog::where('type', 'view')->count();
        $rawDownloadCount = AnalyticsLog::where('type', 'download')->count();
        $rawBookmarkCount = AnalyticsLog::where('type', 'bookmark')->orWhere('type', 'like')->count();
        $ratingAverage = AnalyticsLog::where('type', 'rating')->avg('value') ?? 0;

        // 2. Format angka agar sesuai dengan UI (misal: 125.4K)
        $viewCount = $this->formatNumberShort($rawViewCount);
        $downloadCount = $this->formatNumberShort($rawDownloadCount);
        $bookmarkCount = $this->formatNumberShort($rawBookmarkCount);

        // 3. Olah data Heatmap (Menghitung aktivitas berdasarkan jam 00-23 hari ini)
        $heatmapRaw = AnalyticsLog::select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as count'))
            ->whereDate('created_at', Carbon::today())
            ->groupBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        $heatmapData = [];
        for ($i = 0; $i < 24; $i++) {
            $heatmapData[] = $heatmapRaw[$i] ?? 0;
        }

        // 4. Data Aktual dari Tabel Lainnya
        // Komentar
        $komentarCount = $this->formatNumberShort(DB::table('comments')->count());
        
        // Feedback
        $feedbackCount = $this->formatNumberShort(DB::table('feedback')->count());
        
        // Keyword (Menghitung jumlah query pencarian yang unik)
        $keywordCount = $this->formatNumberShort(DB::table('search_logs')->distinct('query')->count('query'));
        
        // User Aktif (Menggunakan tabel sessions, menghitung sesi yang aktif dalam 24 jam terakhir)
        $twentyFourHoursAgo = Carbon::now()->subDay()->getTimestamp();
        $userAktifCount = $this->formatNumberShort(
            DB::table('sessions')->where('last_activity', '>=', $twentyFourHoursAgo)->count()
        );

        // 5. Top Search Aktual
        // Mengambil 4 query terbanyak dari search_logs
        $topSearchesRaw = DB::table('search_logs')
            ->select('query as keyword', DB::raw('count(*) as count'))
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit(4)
            ->get();

        $topSearches = $topSearchesRaw->map(function($item) {
            return [
                'keyword' => $item->keyword,
                'count_formatted' => $this->formatNumberShort($item->count)
            ];
        });

        // 6. Knowledge Gap Aktual
        // Mengambil pencarian yang tidak membuahkan hasil (results_count = 0)
        $knowledgeGaps = DB::table('search_logs')
            ->select('query as keyword', DB::raw('count(*) as search_count'))
            ->where('results_count', 0)
            ->groupBy('query')
            ->orderByDesc('search_count')
            ->limit(3)
            ->get()
            ->map(function($item) {
                return [
                    'keyword' => $item->keyword,
                    'search_count' => $item->search_count,
                    'article_count' => 0 // Selalu 0 karena dicari dari results_count = 0
                ];
            });

        return view('admin-analytics', compact(
    'viewCount', 'downloadCount', 'bookmarkCount', 'ratingAverage',
    'komentarCount', 'feedbackCount', 'keywordCount', 'userAktifCount',
    'heatmapData', 'topSearches', 'knowledgeGaps'
));
    }

    // Helper method untuk format angka ke "K" (Ribu) atau "M" (Juta)
    private function formatNumberShort($num)
    {
        if ($num >= 1000000) {
            return round($num / 1000000, 1) . 'M';
        }
        if ($num >= 1000) {
            return round($num / 1000, 1) . 'K';
        }
        return $num;
    }
}