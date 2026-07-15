<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\DocumentVersion;
use App\Models\Bookmark;
use App\Models\Rating;
use App\Models\Like;
use App\Models\UserActivity;
use App\Models\Feedback;      // Tambahkan model Feedback
use App\Models\Notification;  // Tambahkan model Notification
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    /**
     * Tampilkan detail artikel berdasarkan slug.
     */
    public function show($slug)
    {
        // 1. Ambil artikel berdasarkan slug
        $article = Article::with(['user', 'category'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        // 2. Tambah jumlah views
        $article->increment('views');

        // ✨ CATAT AKTIVITAS: View Document
        UserActivity::create([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'type'       => 'View Document',
            'description'=> 'Melihat dokumen: ' . $article->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

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

        // ✨ CATAT AKTIVITAS: Download PDF
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
            // ✨ CATAT AKTIVITAS: Unlike
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
            // ✨ CATAT AKTIVITAS: Like
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

        // ✨ CATAT AKTIVITAS: Rating
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
            // ✨ CATAT AKTIVITAS: Unbookmark
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
            // ✨ CATAT AKTIVITAS: Bookmark
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
     * ✨ FITUR BARU: Menerima feedback dari user (rating + komentar)
     * Jika rating ≤ 3, kirim notifikasi ke Admin.
     */
    public function submitFeedback(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();

        // 1. Cegah spam: cek apakah user sudah pernah memberi feedback untuk artikel ini
        $exists = Feedback::where('user_id', $user->id)
            ->where('article_id', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'already_submitted',
                'message' => 'Anda sudah memberikan feedback untuk artikel ini.'
            ]);
        }

        // 2. Validasi input
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 3. Simpan feedback
        $feedback = Feedback::create([
            'article_id'   => $article->id,
            'user_id'      => $user->id,
            'feedback_type'=> 'Rating',   // Bisa disesuaikan
            'status'       => 'Open',
            'message'      => $request->comment ?? '', // Jika ingin simpan di message juga
            'rating'       => $request->rating,
            'comment'      => $request->comment,
        ]);

        // 4. Catat aktivitas user (opsional)
        UserActivity::create([
            'user_id'    => $user->id,
            'article_id' => $article->id,
            'type'       => 'Feedback',
            'description'=> 'Memberikan rating ' . $request->rating . ' bintang pada artikel: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // 5. Jika rating ≤ 3, kirim notifikasi ke Admin
        if ($request->rating <= 3) {
            Notification::create([
                'user_id'    => null, // Null = semua Admin
                'article_id' => $article->id,
                'type'       => 'Feedback',
                'title'      => '👎 Feedback Negatif Diterima',
                'message'    => 'Pengguna ' . $user->name . ' memberikan rating ' . $request->rating . ' bintang pada artikel "' . $article->title . '".',
                'url'        => route('admin.feedback'), // Pastikan route ini ada
                'is_read'    => false,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih atas feedback Anda!'
        ]);
    }
}