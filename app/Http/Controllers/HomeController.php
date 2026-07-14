<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User; // Tambahkan ini!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Helper untuk menerapkan filter visibilitas berdasarkan Role User saat ini.
     */
    private function applyVisibilityFilter($query)
    {
        $user = Auth::user();
        $roleName = optional($user->role)->name ?? 'user';

        // 1. Selalu tampilkan artikel 'public'
        $query->where('visibility', 'public');

        if ($user) {
            // 2. Staff dan Admin boleh lihat 'internal'
            if (in_array($roleName, ['staff', 'admin'])) {
                $query->orWhere('visibility', 'internal');
            }

            // 3. Aturan 'private'
            if ($roleName === 'admin') {
                $query->orWhere('visibility', 'private');
            } else {
                // Jika Staff, mereka hanya boleh melihat private miliknya sendiri
                if ($roleName === 'staff') {
                    $query->orWhere(function ($q) use ($user) {
                        $q->where('visibility', 'private')
                          ->where('user_id', $user->id);
                    });
                }
            }
        }
    }

    public function index(Request $request)
    {
        // --- CEK REDIRECT JIKA SUDAH LOGIN ---
        if (auth()->check()) {
            $user = auth()->user();
            $roleName = $user->role ? $user->role->name : 'user';

            if ($roleName === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
            if ($roleName === 'staff') {
                return redirect()->to('/staff/dashboard');
            }
        }

        // --- DATA STATISTIK UNTUK HEADER ---

        // FIX: Hapus whereNotNull('published_at') di Home Controller agar statistik 0+ hilang.
        // Query ini akan menghitung semua artikel dengan status 'published' (dan tetap memperhatikan Visibilitas user).
        $visibleArticlesQuery = Article::where('status', 'published');
        $this->applyVisibilityFilter($visibleArticlesQuery);

        $stats = [
            // 1. Total Public Documents (Total artikel Published)
            'total_articles' => (clone $visibleArticlesQuery)->count(),

            // 2. Active Regional IT Assets (Total seluruh User terdaftar di sistem)
            'total_opds' => User::count(),

            // 3. Total Downloads (Total unduhan dari artikel yang terlihat)
            'total_downloads' => (clone $visibleArticlesQuery)->sum('downloads'),

            // 4. Gov Agencies Connected (Total Staff & Admin yang terdaftar)
            'total_views' => User::whereHas('role', function($q) {
                $q->whereIn('name', ['staff', 'admin']);
            })->count(),
        ];

        // --- DATA KATEGORI ---
        $categories = Category::all();

        // --- DATA ARTIKEL UNTUK CAROUSEL & GRID (Menyesuaikan published_at) ---
        // Di sini kita tetap memakai whereNotNull('published_at') agar artikel yang tampil 
        // konsisten dengan halaman Knowledge Base.
        $latestQuery = Article::where('status', 'published')
                              ->whereNotNull('published_at')
                              ->with(['user', 'category']);
        $this->applyVisibilityFilter($latestQuery);
        $latestArticles = $latestQuery->orderBy('created_at', 'desc')->take(8)->get();

        $trendingQuery = Article::where('status', 'published')
                                ->whereNotNull('published_at')
                                ->with(['user', 'category']);
        $this->applyVisibilityFilter($trendingQuery);
        $trendingArticles = $trendingQuery->orderBy('rating_avg', 'desc')->take(5)->get();

        $popularQuery = Article::where('status', 'published')
                               ->whereNotNull('published_at')
                               ->with(['user', 'category']);
        $this->applyVisibilityFilter($popularQuery);
        $popularArticles = $popularQuery->orderBy('views', 'desc')->take(5)->get();

        return view('welcome', compact('stats', 'categories', 'latestArticles', 'trendingArticles', 'popularArticles'));
    }
}