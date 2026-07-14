<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    /**
     * Menampilkan List Artikel (All, Pending, Draft, dll)
     * View yang dipanggil disesuaikan dengan file 'admin-allarticles.blade.php' yang sudah ada di project.
     */
    public function index(Request $request, $status = null)
    {
        $query = Article::with('user'); // Eager loading user penulis

        if ($status) {
            $query->where('status', $status);
        }
        
        $articles = $query->orderBy('created_at', 'desc')->paginate(15);

        // 🛑 PERBAIKAN PENTING: Mengarahkan ke view 'admin-allarticles' (sesuai file Anda)
        return view('admin-allarticles', compact('articles', 'status'));
    }

    /**
     * Approve Artikel (Mengubah status pending menjadi published)
     */
    public function approve($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['status' => 'published']);
        return back()->with('success', 'Artikel berhasil disetujui dan dipublikasikan!');
    }

    /**
     * Reject Artikel (Mengubah status pending menjadi rejected)
     */
    public function reject($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['status' => 'rejected']);
        return back()->with('success', 'Artikel ditolak.');
    }

    /**
     * Hapus permanen atau soft delete artikel
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete(); // Pastikan Model Article sudah menggunakan trait SoftDeletes
        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}