<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\SearchLog;
use App\Models\UserActivity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KnowledgeBaseController extends Controller
{
    /**
     * Helper untuk menerapkan filter visibilitas berdasarkan Role User saat ini.
     */
    private function applyVisibilityFilter($query)
    {
        $user = Auth::user();

        // Set default role 'user' untuk Guest
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

    public function index(Request $request)
    {
        // =========================================================
        // ✨ CATAT AKTIVITAS: Membuka halaman Knowledge Base
        // =========================================================
        $desc = 'Membuka halaman Knowledge Base';
        if ($request->filled('search')) {
            $desc .= ' dengan pencarian: "' . $request->search . '"';
        }
        if ($request->filled('category')) {
            $desc .= ' dengan filter kategori: ' . $request->category;
        }
        UserActivity::create([
            'user_id'       => auth()->check() ? auth()->id() : null,
            'type'          => 'View Knowledge Base',
            'description'   => $desc,
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
        ]);

        // =========================================================
        // LOGIKA UTAMA QUERY
        // =========================================================
        // 1. Kategori
        $categories = Category::withCount(['articles' => function ($q) {
            $q->where('status', 'published')
              ->whereNotNull('published_at');
            $this->applyVisibilityFilter($q);
        }])->orderBy('name')->get();

        // 2. Query artikel
        $query = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->with([
                'user:id,name,avatar',
                'category:id,name,slug'
            ]);

        $query->where(function ($q) {
            $this->applyVisibilityFilter($q);
        });

        // 3. Search judul / excerpt
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q
                ->where('title', 'like', "%{$s}%")
                ->orWhere('excerpt', 'like', "%{$s}%")
            );
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Total semua artikel yang terlihat
        $totalArticles = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->where(function ($q) {
                $this->applyVisibilityFilter($q);
            })
            ->count();

        // Paginate
        $articles = $query
            ->orderBy('published_at', 'desc')
            ->paginate(6)
            ->appends($request->except('page'));

        // =========================================================
        // ✨ CATAT AKTIVITAS: Klik Artikel (Hanya dari hasil pencarian)
        // =========================================================
        // (Logika ini sebenarnya ditangani oleh route /api/track-click, 
        //  tetapi jika ingin mencatat klik artikel secara umum di luar pencarian,
        //  Anda bisa menambahkan logika di sini. Saat ini sudah ada di route.)

        // =========================================================
        // ✨ CATAT KE SEARCH LOG (Jika ada pencarian)
        // =========================================================
        if ($request->filled('search')) {
            SearchLog::create([
                'query'         => $request->search,
                'user_id'       => auth()->check() ? auth()->id() : null,
                'results_count' => $articles->total(),
                'user_agent'    => $request->userAgent(),
                'ip_address'    => $request->ip(),
            ]);

            // ✨ Tambahan: Catat juga ke UserActivity untuk aktivitas search
            UserActivity::create([
                'user_id'       => auth()->check() ? auth()->id() : null,
                'type'          => 'Search Article',
                'description'   => 'Mencari artikel dengan kata kunci: "' . $request->search . '"',
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
            ]);
        }

        return view('knowledge-base', compact('categories', 'articles', 'totalArticles'));
    }
}