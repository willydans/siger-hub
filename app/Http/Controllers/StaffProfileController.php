<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StaffProfileController extends Controller
{
    // Menampilkan halaman profil staff
    public function index()
    {
        $user = auth()->user();

        // --- 1. Statistik Pencapaian ---
        $stats = [
            'total_articles' => Article::where('user_id', $user->id)->count(),
            'published'      => Article::where('user_id', $user->id)->where('status', 'published')->count(),
            'views'          => Article::where('user_id', $user->id)->sum('views'),
            'downloads'      => Article::where('user_id', $user->id)->sum('downloads'),
            
            // ✅ PERBAIKAN 1: Jadikan 0 dulu jika belum ada tabel/kolom likes_count di database
            'likes'          => 0, 
            
            // ✅ PERBAIKAN 2: Ubah 'rating_avg' menjadi 'rating' sesuai nama kolom asli di MySQL
            'rating'         => Article::where('user_id', $user->id)->avg('rating'), 
            
            'comments'       => Article::where('user_id', $user->id)->sum('comments_count'),
        ];
        
        // --- 2. Timeline Aktivitas (mengambil 5 artikel terbaru yang diupdate) ---
        $recentActivities = Article::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // --- 3. Badge Logic (Pencapaian) ---
        $badges = [
            'top_contributor'   => $stats['total_articles'] >= 5,
            'knowledge_master'  => $stats['total_articles'] >= 20,
            'most_viewed'       => $stats['views'] >= 5000,
            '100_articles'      => $stats['total_articles'] >= 100,
        ];

        return view('staff-profile', compact('user', 'stats', 'recentActivities', 'badges'));
    }

    // Update data profil staff
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => 'nullable|string|max:50',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'bidang'    => 'nullable|string|max:255',
            'jabatan'   => 'nullable|string|max:255',
            'no_hp'     => 'nullable|string|max:20',
            'bio'       => 'nullable|string',
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        // Siapkan data untuk diupdate
        $data = $request->except(['password', 'password_confirmation']);
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}