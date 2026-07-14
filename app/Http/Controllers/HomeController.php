<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // --- CEK REDIRECT JIKA SUDAH LOGIN ---
        if (auth()->check()) {
            $user = auth()->user();
            
            // ✅ PERBAIKAN: Gunakan relasi role untuk mendapatkan nama role
            $roleName = $user->role ? $user->role->name : 'user';

            // Hanya Admin dan Staff yang dipaksa redirect ke dashboard.
            if ($roleName === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
            if ($roleName === 'staff') {
                return redirect()->to('/staff/dashboard');
            }
            // Jika role 'user', jangan redirect kemanapun.
            // Biarkan mereka menikmati halaman publik (welcome) di bawah ini.
        }

        // --- DATA UNTUK GUEST / WELCOME PAGE ---
        // 1. Data Statistik
        $stats = [
            'total_articles' => Article::where('status', 'published')->count(),
            'total_views'    => Article::sum('views'),
            'total_downloads'=> Article::sum('downloads'),
            'total_opds'     => Opd::count(),
        ];

        // 2. Data Kategori (Untuk Icon Circular)
        $categories = Category::all();

        // 3. Data Artikel Terbaru (Untuk Bagian Public SOPs & Guidelines)
        $latestArticles = Article::where('status', 'published')
            ->with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // 4. Data Artikel Trending (Rating Tertinggi)
        $trendingArticles = Article::where('status', 'published')
            ->with(['user', 'category'])
            ->orderBy('rating_avg', 'desc')
            ->take(5)
            ->get();

        // 5. Data Artikel Populer (Views Tertinggi)
        $popularArticles = Article::where('status', 'published')
            ->with(['user', 'category'])
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('welcome', compact('stats', 'categories', 'latestArticles', 'trendingArticles', 'popularArticles'));
    }
}