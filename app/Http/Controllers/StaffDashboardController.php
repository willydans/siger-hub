<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $userId = auth()->id();

        // 1. Data Statistik Ringkasan
        $totalArticles = Article::where('user_id', $userId)->count();
        $draftCount    = Article::where('user_id', $userId)->where('status', 'draft')->count();
        $pendingCount  = Article::where('user_id', $userId)->where('status', 'pending')->count();
        $published     = Article::where('user_id', $userId)->where('status', 'published')->count();
        $rejectedCount = Article::where('user_id', $userId)->where('status', 'rejected')->count();

        // ⚠️ PERBAIKAN SEMENTARA: Gunakan nilai 0 karena kolom views, rating, comments_count belum ada.
        // Setelah migrasi database berhasil, Anda bisa mengaktifkan query di bawah.
        $totalViews    = 0;
        $avgRating     = 0;
        $totalComments = 0;
        /*
        // 🔥 Query aktif jika kolom sudah ada:
        $totalViews    = Article::where('user_id', $userId)->sum('views');
        $avgRating     = Article::where('user_id', $userId)->avg('rating');
        $totalComments = Article::where('user_id', $userId)->sum('comments_count');
        */

        // 2. Data Chart Artikel per Bulan
        $chartLabels = [];
        $chartData = [];
        for ($i = 4; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M');
            $count = Article::where('user_id', $userId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $chartData[] = $count;
        }

        // 3. Top 5 Artikel (Untuk sementara diurutkan berdasarkan terbaru, karena views belum ada)
        $popularArticles = Article::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. Aktivitas Terbaru
        $recentActivities = Article::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('staff-dashboard', compact(
            'totalArticles', 'draftCount', 'pendingCount', 'published', 'rejectedCount',
            'totalViews', 'avgRating', 'totalComments',
            'chartLabels', 'chartData', 'popularArticles', 'recentActivities'
        ));
    }
}