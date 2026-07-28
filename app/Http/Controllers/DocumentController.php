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
        $relatedArticles = Article::where('category_id', $article->category_id)
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
    public function toggleLike($id)
    {
        $article = \App\Models\Article::findOrFail($id);
        $userId = auth()->id();

        // Cek apakah user sudah like artikel ini sebelumnya
        $like = \App\Models\Like::where('user_id', $userId)->where('article_id', $id)->first();

        if ($like) {
            // Jika sudah like, maka hapus (Unlike)
            $like->delete();
            $isLiked = false;
        } else {
            // Jika belum, tambahkan data Like
            \App\Models\Like::create([
                'user_id' => $userId,
                'article_id' => $id
            ]);
            $isLiked = true;
        }

        // Hitung total like terbaru
        $likeCount = \App\Models\Like::where('article_id', $id)->count();
        
        // (Opsional) Update kolom likes_count di tabel articles jika Anda menggunakannya
        // $article->update(['likes_count' => $likeCount]);

        // ✅ BALASAN HARUS JSON SEPERTI INI AGAR JAVASCRIPT BEKERJA
        return response()->json([
            'success' => true,
            'liked'   => $isLiked,
            'count'   => $likeCount
        ]);
    }

    /**
     * Beri rating artikel.
     */
    public function rate(Request $request, $id)
    {
        // Validasi input rating dari JavaScript
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);
        
        $userId = auth()->id();

        // UpdateOrCreate: Simpan atau update nilai rating dari user ini
        \App\Models\Rating::updateOrCreate(
            ['user_id' => $userId, 'article_id' => $id],
            ['rating' => $request->rating]
        );

        // Hitung rata-rata rating terbaru dari tabel ratings
        $avgRating = \App\Models\Rating::where('article_id', $id)->avg('rating');
        
        // KITA MENGHAPUS BAGIAN $article->save() DI SINI
        // KARENA KOLOM rating_avg BELUM DIBUAT DI DATABASE ANDA

        return response()->json([
            'success' => true,
            'avg'     => number_format($avgRating, 1) 
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
        // Validasi input dari modal
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $userId = auth()->id();

        // (Opsional) Cek apakah user sudah pernah memberi feedback agar tidak dobel
        // Pastikan Anda sudah membuat Model Feedback beserta migration-nya.
        $exists = \App\Models\Feedback::where('user_id', $userId)
                                      ->where('article_id', $id)
                                      ->exists();

        if ($exists) {
            return response()->json(['status' => 'already_submitted']);
        }

        // Simpan feedback ke database
        \App\Models\Feedback::create([
            'user_id'    => $userId,
            'article_id' => $id,
            'rating'     => $request->rating,
            'comment'    => $request->comment
        ]);

        // Balas dengan status JSON sukses agar modal tertutup otomatis
        return response()->json(['status' => 'success']);
    }
}