<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Feedback;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Helper untuk menghitung total ukuran folder dalam direktori public storage
     */
    private function getStorageSize()
    {
        // Ganti 'articles' dan 'uploads' sesuai nama folder penyimpanan file Anda di storage/app/public
        $directories = ['articles', 'uploads', 'attachments'];
        $totalBytes = 0;

        foreach ($directories as $dir) {
            // Cek apakah folder ada di public disk
            if (Storage::disk('public')->exists($dir)) {
                // Ambil semua file di dalam folder (termasuk subfolder)
                $files = Storage::disk('public')->allFiles($dir);
                
                foreach ($files as $file) {
                    $totalBytes += Storage::disk('public')->size($file);
                }
            }
        }

        // Konversi Byte ke GB (jika totalBytes > 0)
        if ($totalBytes > 0) {
            return number_format($totalBytes / 1024 / 1024 / 1024, 1) . ' GB';
        }

        return '0 GB';
    }

    public function index()
    {
        // --- Statistik Kartu ---
        $data = [
            'totalUsers'    => User::count(),
            // ✅ PERBAIKAN: Menggunakan whereHas untuk mencari user dengan role 'staff'
            'totalStaff'    => User::whereHas('role', function ($query) {
                                    $query->where('name', 'staff');
                                })->count(),
            'totalArticles' => Article::count(),
            'pending'       => Article::where('status', 'pending')->count(),
            'published'     => Article::where('status', 'published')->count(),
            'rejected'      => Article::where('status', 'rejected')->count(),
            'archived'      => Article::where('status', 'archived')->count(),
            // ✅ PERBAIKAN: Menggunakan 'private' sesuai nilai database
            'private'       => Article::where('visibility', 'private')->count(),
            'feedback'      => Feedback::count(),
            // ✅ PERBAIKAN: Menggunakan kolom 'rating_avg' yang benar
            'rating'        => number_format(Article::avg('rating_avg'), 1),
            
            // ✨ DINAMIS: Mengambil total ukuran file dari Laravel Storage
            'storage'       => $this->getStorageSize(),
            
            // ✨ DINAMIS: Menjumlahkan total download dari kolom 'downloads' pada tabel Articles
            'download'      => number_format(Article::sum('downloads') ?: 0),
        ];

        // --- Data Grafik Upload Bulanan ---
        $uploadData = [];
        for ($i = 1; $i <= 6; $i++) {
            $month = Carbon::now()->subMonths(6 - $i);
            $count = Article::whereYear('created_at', $month->year)
                            ->whereMonth('created_at', $month->month)
                            ->count();
            $uploadData[] = $count;
        }

        // --- Data Grafik OPD (Pie Chart) ---
        // Catatan: query ini mencari berdasarkan kolom 'category' di tabel articles.
        // Jika Anda ingin menggunakan relasi OPD, Anda bisa menyesuaikan di sini.
        $opdData = [
            'Kominfo' => Article::where('category', 'Kominfo')->count(),
            'BKD'     => Article::where('category', 'BKD')->count(),
            'Bappeda' => Article::where('category', 'Bappeda')->count(),
            'Dinkes'  => Article::where('category', 'Dinkes')->count(),
            'Disdik'  => Article::where('category', 'Disdik')->count(),
            'Inspektorat' => Article::where('category', 'Inspektorat')->count(),
        ];

        // --- Data Grafik Status (Donut Chart) ---
        $statusData = [
            'Draft'     => Article::where('status', 'draft')->count(),
            'Pending'   => Article::where('status', 'pending')->count(),
            'Published' => Article::where('status', 'published')->count(),
            'Revision'  => Article::where('status', 'revision')->count(),
            'Archive'   => Article::where('status', 'archived')->count(),
            'Delete'    => Article::onlyTrashed()->count(),
        ];

        // --- Widget Data ---
        $topContributors = User::withCount('articles')->orderBy('articles_count', 'desc')->take(3)->get();
        $topArticles = Article::orderBy('views', 'desc')->take(3)->get();

        return view('admin-dashboard', compact('data', 'uploadData', 'opdData', 'statusData', 'topContributors', 'topArticles'));
    }
}