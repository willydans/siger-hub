<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
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
        
        // Dapatkan nama role user (amankan jika role null)
        $roleName = optional($user->role)->name ?? 'user';

        // 1. Selalu tampilkan artikel 'public' untuk semua orang
        $query->where('visibility', 'public');

        if ($user) {
            // 2. Role Staff dan Admin boleh melihat artikel 'internal'
            if (in_array($roleName, ['staff', 'admin'])) {
                $query->orWhere('visibility', 'internal');
            }

            // 3. Aturan untuk 'private'
            // - Admin bisa melihat semua private
            // - Staff hanya bisa melihat private miliknya sendiri
            if ($roleName === 'admin') {
                $query->orWhere('visibility', 'private');
            } else {
                // Ini berlaku untuk Staff dan User biasa. Tapi User biasa tadi sudah terfilter oleh 'public'.
                // Jika role Staff, mereka hanya boleh lihat private milik user_id mereka.
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
        // 1. Kategori — hitung artikel yang sudah dipublikasi DAN terlihat oleh user yang login
        $categories = Category::withCount(['articles' => function ($q) {
            $q->where('status', 'published')
              ->whereNotNull('published_at');
            $this->applyVisibilityFilter($q); // Terapkan filter visibilitas!
        }])->orderBy('name')->get();

        // 2. Query artikel — Pakai logika sama + Filter Visibilitas
        $query = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->with([
                'user:id,name,avatar',
                'category:id,name,slug'
            ]);

        // Terapkan filter visibilitas ke query utama!
        $query->where(function ($q) {
            $this->applyVisibilityFilter($q);
        });

        // Search judul / excerpt
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

        // Total semua artikel yang terlihat (untuk badge sidebar "All Topics")
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

        return view('knowledge-base', compact('categories', 'articles', 'totalArticles'));
    }
}