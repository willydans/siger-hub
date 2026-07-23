<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\DocumentVersion;
use App\Models\Bookmark;
use App\Models\Rating;
use App\Models\Like;
use App\Models\UserActivity;
use App\Models\Feedback;
use App\Models\Notification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    /**
     * Tampilkan detail artikel berdasarkan slug.
     */
    public function show($slug)
    {
        $article = Article::with(['user', 'category'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        $article->increment('views');

        UserActivity::create([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'type'       => 'View Document',
            'description'=> 'Melihat dokumen: ' . $article->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $comments = $article->comments()->with('user')->latest()->get();
        $revisions = DocumentVersion::where('article_id', $article->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        $relatedArticles = Article::where('category', $article->category)
                    ->where('id', '!=', $article->id)
                    ->where('status', 'published')
                    ->limit(5)
                    ->get();

        // ✨ Ambil rating user yang sedang login (jika ada)
        $userRating = null;
        if (auth()->check()) {
            $userRating = Rating::where('user_id', auth()->id())
                                ->where('article_id', $article->id)
                                ->value('rating');
        }

        return view('document-detail', compact(
            'article', 'comments', 'revisions', 'relatedArticles', 'userRating'
        ));
    }

    /**
     * Download artikel dalam format PDF.
     */
    public function downloadPdf($id)
    {
        $article = Article::with('user')->findOrFail($id);

        $article->increment('views');
        $article->increment('downloads');

        UserActivity::create([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'type'       => 'Download PDF',
            'description'=> 'Mengunduh PDF dokumen: ' . $article->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

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
            UserActivity::create([
                'user_id'    => $user->id,
                'type'       => 'Unlike Article',
                'description'=> 'Membatalkan suka pada artikel: ' . $article->title,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } else {
            Like::create(['user_id' => $user->id, 'article_id' => $article->id]);
            $article->increment('likes_count');
            $liked = true;
            UserActivity::create([
                'user_id'    => $user->id,
                'type'       => 'Like Article',
                'description'=> 'Menyukai artikel: ' . $article->title,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $article->likes_count
        ]);
    }

    /**
     * Beri rating artikel (update atau create).
     */
    public function rate(Request $request, $id)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);
        $article = Article::findOrFail($id);
        $user = auth()->user();

        // ✅ updateOrCreate memastikan hanya satu rating per user per artikel
        Rating::updateOrCreate(
            ['user_id' => $user->id, 'article_id' => $article->id],
            ['rating' => $request->rating]
        );

        // Hitung ulang rata-rata dan jumlah rating
        $avgRating = Rating::where('article_id', $article->id)->avg('rating');
        $countRating = Rating::where('article_id', $article->id)->count();

        $article->update([
            'rating_avg' => $avgRating,
            'rating_count' => $countRating
        ]);

        UserActivity::create([
            'user_id'    => $user->id,
            'type'       => 'Rate Article',
            'description'=> 'Memberi rating ' . $request->rating . ' bintang pada artikel: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'avg' => number_format($avgRating, 1),
            'count' => $countRating,
            'user_rating' => $request->rating // ✅ kirim balik rating yang dipilih
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
            UserActivity::create([
                'user_id'    => $user->id,
                'type'       => 'Unbookmark Article',
                'description'=> 'Menghapus bookmark pada artikel: ' . $article->title,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } else {
            Bookmark::create(['user_id' => $user->id, 'article_id' => $article->id]);
            $bookmarked = true;
            UserActivity::create([
                'user_id'    => $user->id,
                'type'       => 'Bookmark Article',
                'description'=> 'Menambahkan bookmark pada artikel: ' . $article->title,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked
        ]);
    }

    /**
     * Menerima feedback dari user (rating + komentar).
     * Jika rating ≤ 3, kirim notifikasi ke Admin.
     */
    public function submitFeedback(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();

        $exists = Feedback::where('user_id', $user->id)
            ->where('article_id', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'already_submitted',
                'message' => 'Anda sudah memberikan feedback untuk artikel ini.'
            ]);
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Feedback::create([
            'article_id'   => $article->id,
            'user_id'      => $user->id,
            'feedback_type'=> 'Rating',
            'status'       => 'Open',
            'message'      => $request->comment ?? '',
            'rating'       => $request->rating,
            'comment'      => $request->comment,
        ]);

        UserActivity::create([
            'user_id'    => $user->id,
            'article_id' => $article->id,
            'type'       => 'Feedback',
            'description'=> 'Memberikan rating ' . $request->rating . ' bintang pada artikel: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->rating <= 3) {
            Notification::create([
                'user_id'    => null,
                'article_id' => $article->id,
                'type'       => 'Feedback',
                'title'      => '👎 Feedback Negatif Diterima',
                'message'    => 'Pengguna ' . $user->name . ' memberikan rating ' . $request->rating . ' bintang pada artikel "' . $article->title . '".',
                'url'        => route('admin.feedback'),
                'is_read'    => false,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih atas feedback Anda!'
        ]);
    }
}