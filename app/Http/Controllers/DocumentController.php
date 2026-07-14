<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\DocumentVersion;
use App\Models\Bookmark;
use App\Models\Rating;
use App\Models\Like;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    /**
     * Tampilkan detail artikel berdasarkan slug.
     */
    public function show($slug)
    {
        // 1. Ambil artikel berdasarkan slug, pastikan status published, load relasi user & category
        $article = Article::with(['user', 'category'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        // 2. Tambah jumlah views setiap kali artikel dibuka
        $article->increment('views');

        // 3. Ambil Komentar
        $comments = $article->comments()->with('user')->latest()->get();

        // 4. Ambil Riwayat Revisi
        $revisions = DocumentVersion::where('article_id', $article->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        // 5. Ambil Artikel Terkait
        $relatedArticles = Article::where('category', $article->category)
                    ->where('id', '!=', $article->id)
                    ->where('status', 'published')
                    ->limit(5)
                    ->get();

        return view('document-detail', compact('article', 'comments', 'revisions', 'relatedArticles'));
    }

    /**
     * Download artikel dalam format PDF.
     */
    public function downloadPdf($id)
    {
        $article = Article::with('user')->findOrFail($id);

        // Tambah views & downloads
        $article->increment('views');
        $article->increment('downloads');

        $pdf = Pdf::loadView('pdf.article', compact('article'));
        return $pdf->download('dokumen-' . $article->slug . '.pdf');
    }

    /**
     * Toggle Like.
     */
    public function toggleLike(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();

        $like = Like::where('user_id', $user->id)->where('article_id', $article->id)->first();

        if ($like) {
            $like->delete();
            $article->decrement('likes_count');
            $liked = false;
        } else {
            Like::create(['user_id' => $user->id, 'article_id' => $article->id]);
            $article->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $article->likes_count
        ]);
    }

    /**
     * Beri rating artikel.
     */
    public function rate(Request $request, $id)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);
        $article = Article::findOrFail($id);
        $user = auth()->user();

        $rating = Rating::updateOrCreate(
            ['user_id' => $user->id, 'article_id' => $article->id],
            ['rating' => $request->rating]
        );

        // Update rating rata-rata di tabel articles
        $avgRating = Rating::where('article_id', $article->id)->avg('rating');
        $countRating = Rating::where('article_id', $article->id)->count();

        $article->update([
            'rating_avg' => $avgRating,
            'rating_count' => $countRating
        ]);

        return response()->json([
            'success' => true,
            'avg' => number_format($avgRating, 1),
            'count' => $countRating
        ]);
    }

    /**
     * Toggle Bookmark.
     */
    public function toggleBookmark(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();

        $bookmark = Bookmark::where('user_id', $user->id)->where('article_id', $article->id)->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
        } else {
            Bookmark::create(['user_id' => $user->id, 'article_id' => $article->id]);
            $bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked
        ]);
    }
}