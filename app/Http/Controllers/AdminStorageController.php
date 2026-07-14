<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminStorageController extends Controller
{
    /**
     * Menampilkan halaman Storage dengan data dinamis.
     */
    public function index()
    {
        // --- 1. Analisis Data Storage Laravel ---
        $disk = Storage::disk('public');
        $allFiles = $disk->allFiles('/'); // Ambil semua file di storage/public

        $totalSize = 0;
        $fileExtensions = [];
        $topFiles = [];
        $orphanFiles = [];
        $usedPaths = [];

        // 2. Ambil semua path file yang digunakan oleh Artikel (dari thumbnail, attachments, dan content)
        $articles = Article::select('thumbnail', 'attachments', 'content')->get();
        foreach ($articles as $article) {
            if ($article->thumbnail) $usedPaths[] = $article->thumbnail;
            
            // Panggil kolom yang benar
            $attachments = $article->attachments; 
            
            if (is_string($attachments)) {
                $attachments = json_decode($attachments, true);
            }
            if (is_array($attachments)) {
                foreach ($attachments as $att) {
                    if (isset($att['path'])) $usedPaths[] = $att['path'];
                }
            }

            // Regex sederhana untuk mencari src gambar di konten HTML
            preg_match_all('/src="([^"]*)"/', $article->content, $matches);
            foreach ($matches[1] as $src) {
                // Menghapus URL base jika menggunakan full URL
                $relativePath = str_replace(asset('storage/'), '', $src);
                $usedPaths[] = $relativePath;
            }
        }
        $usedPaths = array_unique(array_filter($usedPaths));

        // --- 3. Loop file untuk menghitung statistik dan mendeteksi Orphan (Yatim) ---
        foreach ($allFiles as $file) {
            $size = $disk->size($file);
            $totalSize += $size;

            // Statistik ekstensi
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (!isset($fileExtensions[$ext])) {
                $fileExtensions[$ext] = 0;
            }
            $fileExtensions[$ext]++;

            // Top 5 File Terbesar
            $topFiles[] = [
                'path' => $file,
                'name' => basename($file),
                'size' => $size,
                'size_human' => $this->formatBytes($size),
            ];

            // Deteksi File Yatim / Tidak Digunakan
            $isUsed = false;
            foreach ($usedPaths as $usedPath) {
                // Cek apakah file saat ini ada di dalam path yang digunakan database
                if (strpos($usedPath, $file) !== false) {
                    $isUsed = true;
                    break;
                }
            }
            if (!$isUsed) {
                $fileInfo = pathinfo($file);
                // Abaikan folder seperti .gitignore atau folder sistem
                if (!str_starts_with($fileInfo['basename'], '.')) {
                    $orphanFiles[] = [
                        'path' => $file,
                        'name' => $fileInfo['basename'],
                        'ext' => $fileInfo['extension'] ?? 'unknown',
                        'last_modified' => $disk->lastModified($file),
                        'size' => $this->formatBytes($size),
                    ];
                }
            }
        }

        // Urutkan topFiles dari yang terbesar
        usort($topFiles, fn($a, $b) => $b['size'] - $a['size']);
        $topFiles = array_slice($topFiles, 0, 5);

        // Batasi jumlah file yatim yang ditampilkan di UI (agar halaman tidak berat)
        $orphanFilesDisplay = array_slice($orphanFiles, 0, 15);

        // --- 4. Data untuk Kartu Statistik ---
        $laravelSize = $this->formatBytes($totalSize);
        $totalFileCount = count($allFiles);
        $pdfCount = $fileExtensions['pdf'] ?? 0;
        $videoCount = ($fileExtensions['mp4'] ?? 0) + ($fileExtensions['avi'] ?? 0) + ($fileExtensions['mkv'] ?? 0);
        $wordCount = ($fileExtensions['doc'] ?? 0) + ($fileExtensions['docx'] ?? 0);
        $imageCount = ($fileExtensions['jpg'] ?? 0) + ($fileExtensions['jpeg'] ?? 0) + ($fileExtensions['png'] ?? 0) + ($fileExtensions['gif'] ?? 0) + ($fileExtensions['webp'] ?? 0);

        // Statistik Nextcloud (Placeholder sampai integrasi Nextcloud selesai)
        $nextcloudSize = '31 GB'; // Jika Nextcloud terintegrasi, ganti ini dengan Storage::disk('nextcloud')->...

        return view('admin-storage', compact(
            'laravelSize', 'nextcloudSize', 'totalFileCount',
            'pdfCount', 'videoCount', 'wordCount', 'imageCount',
            'topFiles', 'orphanFilesDisplay', 'orphanFiles'
        ));
    }

    /**
     * Menghapus file spesifik (Dari tombol Hapus di File Tidak Digunakan)
     */
    public function deleteFile(Request $request)
    {
        $request->validate(['file_path' => 'required|string']);
        $filePath = $request->file_path;

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return back()->with('success', 'File berhasil dihapus!');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    /**
     * Scan & Cleanup (Menghapus semua file yatim / orphan)
     */
    public function cleanup(Request $request)
    {
        $disk = Storage::disk('public');
        $allFiles = $disk->allFiles('/');
        
        // Ambil semua path yang dipakai
        $usedPaths = [];
        $articles = Article::select('thumbnail', 'attachments', 'content')->get();
        foreach ($articles as $article) {
            if ($article->thumbnail) $usedPaths[] = $article->thumbnail;
            
            // ✅ PERBAIKAN KEDUA: Sama seperti di method index
            $attachments = $article->attachments;
            if (is_string($attachments)) {
                $attachments = json_decode($attachments, true);
            }
            if (is_array($attachments)) {
                foreach ($attachments as $att) {
                    if (isset($att['path'])) $usedPaths[] = $att['path'];
                }
            }

            preg_match_all('/src="([^"]*)"/', $article->content, $matches);
            foreach ($matches[1] as $src) {
                $relativePath = str_replace(asset('storage/'), '', $src);
                $usedPaths[] = $relativePath;
            }
        }
        $usedPaths = array_unique(array_filter($usedPaths));

        $deletedCount = 0;
        foreach ($allFiles as $file) {
            $isUsed = false;
            foreach ($usedPaths as $usedPath) {
                if (strpos($usedPath, $file) !== false) {
                    $isUsed = true;
                    break;
                }
            }
            if (!$isUsed && !str_starts_with(basename($file), '.')) {
                $disk->delete($file);
                $deletedCount++;
            }
        }

        return back()->with('success', "Pembersihan selesai! Sebanyak {$deletedCount} file yatim telah dihapus.");
    }

    /**
     * Helper untuk mengubah ukuran file (Bytes) menjadi format manusiawi (MB/GB)
     */
    private function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 1) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }
}