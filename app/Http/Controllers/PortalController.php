<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    /**
     * Helper untuk filter visibilitas (sama seperti di HomeController)
     */
    private function applyVisibilityFilter($query)
    {
        $user = Auth::user();
        $roleName = 'user';
        if ($user) {
            $roleName = optional($user->role)->name ?? 'user';
        }

        $query->where('visibility', 'public');

        if ($user) {
            if (in_array($roleName, ['staff', 'admin'])) {
                $query->orWhere('visibility', 'internal');
            }
            if ($roleName === 'admin') {
                $query->orWhere('visibility', 'private');
            } else {
                if ($roleName === 'staff') {
                    $query->orWhere(function ($q) use ($user) {
                        $q->where('visibility', 'private')
                          ->where('user_id', $user->id);
                    });
                }
            }
        }
    }

    /**
     * Tampilkan portal publik (tanpa redirect)
     */
    public function index(Request $request)
    {
        // ✨ Catat aktivitas (Guest maupun User Login)
        UserActivity::create([
            'user_id'       => auth()->check() ? auth()->id() : null,
            'type'          => 'View Portal Publik',
            'description'   => auth()->check() 
                                ? auth()->user()->name . ' membuka portal publik' 
                                : 'Guest membuka portal publik',
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
        ]);

        // --- DATA STATISTIK UNTUK HEADER ---
        $visibleArticlesQuery = Article::where('status', 'published');
        $this->applyVisibilityFilter($visibleArticlesQuery);

        $stats = [
            'total_articles' => (clone $visibleArticlesQuery)->count(),
            'total_opds' => User::count(),
            'total_downloads' => (clone $visibleArticlesQuery)->sum('downloads'),
            'total_views' => User::whereHas('role', function($q) {
                $q->whereIn('name', ['staff', 'admin']);
            })->count(),
        ];

        $categories = Category::all();

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

        // Kembalikan view welcome (sama seperti home)
        return view('welcome', compact('stats', 'categories', 'latestArticles', 'trendingArticles', 'popularArticles'));
    }
}