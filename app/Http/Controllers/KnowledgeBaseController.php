<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Opd;
use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Semua Kategori untuk Sidebar
        $categories = Category::withCount('articles')->get();

        // 2. Query Artikel (Hanya yang Published)
        $query = Article::where('status', 'published')
                    ->with(['user', 'category']);

        // ✅ Fitur Search (Berdasarkan Judul)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // ✅ Fitur Filter Kategori (Berdasarkan Nama Kategori)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // 3. Pagination & Simpan Query String
        $articles = $query->orderBy('created_at', 'desc')->paginate(6)->appends($request->except('page'));

        $totalArticles = Article::where('status', 'published')->count();

        return view('knowledge-base', compact('categories', 'articles', 'totalArticles'));
    }
}