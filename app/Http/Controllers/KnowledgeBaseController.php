<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        // ✅ PERBAIKAN: Gunakan withCount agar kita bisa menampilkan jumlah artikel per kategori di sidebar.
        $categories = Category::withCount('articles')->get();

        // Ambil Artikel yang sudah Published, load relasi user & category
        $articles = Article::where('status', 'published')
                    ->with(['user', 'category'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);

        $totalArticles = Article::where('status', 'published')->count();

        return view('knowledge-base', compact('categories', 'articles', 'totalArticles'));
    }
}