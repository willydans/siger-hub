<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Notification; // Tambahkan Model Notification
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminStorageController extends Controller
{
    /**
     * Menampilkan halaman Storage dengan data dinamis dan notifikasi otomatis.
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

        // 2. Ambil semua path file yang digunakan oleh Artikel
        $articles = Article::select('thumbnail', 'attachments', 'content')->get();
        foreach ($articles as $article) {
            if ($article->thumbnail) {
                $usedPaths[] = $article->thumbnail;
            }
            
            // Proses attachments (JSON array atau string)
            $attachments = $article->attachments;
            if (is_string($attachments)) {
                $attachments = json_decode($attachments, true);
            }
            if (is_array($attachments)) {
                foreach ($attachments as $att) {
                    if (isset($att['path'])) $usedPaths[] = $att['path'];
                }
            }

            // Regex untuk src="..." di dalam konten HTML
            preg_match_all('/src="([^"]*)"/', $article->content, $matches);
            foreach ($matches[1] as $src) {
                $usedPaths[] = $src;
            }

            // Regex untuk href="..." jika ada link lampiran/file di dalam konten
            preg_match_all('/href="([^"]*)"/', $article->content, $hrefMatches);
            foreach ($hrefMatches[1] as $href) {
                if (preg_match('/\.(pdf|doc|docx|zip|jpg|png|jpeg)$/i', $href)) {
                    $usedPaths[] = $href;
                }
            }
        }
        // Hapus duplikasi dan nilai kosong
        $usedPaths = array_unique(array_filter($usedPaths));

        // --- 3. Loop file untuk menghitung statistik dan mendeteksi Orphan ---
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

            // Deteksi Orphan
            $isUsed = false;
            $normalizedFile = $this->normalizePath($file); 

            foreach ($usedPaths as $usedPath) {
                $normalizedUsed = $this->normalizePath($usedPath); 
                
                if ($normalizedFile === $normalizedUsed || str_ends_with($normalizedUsed, '/' . $normalizedFile)) {
                    $isUsed = true;
                    break;
                }
            }

            if (!$isUsed && !str_starts_with(basename($file), '.')) {
                $orphanFiles[] = [
                    'path' => $file,
                    'name' => basename($file),
                    'ext' => $ext ?? 'unknown',
                    'last_modified' => $disk->lastModified($file),
                    'size' => $this->formatBytes($size),
                ];
            }
        }

        // Urutkan topFiles dari yang terbesar
        usort($topFiles, fn($a, $b) => $b['size'] - $a['size']);
        $topFiles = array_slice($topFiles, 0, 5);

        // Batasi jumlah file orphan yang ditampilkan di UI agar tidak berat
        $orphanFilesDisplay = array_slice($orphanFiles, 0, 15);

        // --- 4. Data untuk Kartu Statistik (Nextcloud Dihapus) ---
        $laravelSize = $this->formatBytes($totalSize);
        $totalFileCount = count($allFiles);
        $pdfCount = $fileExtensions['pdf'] ?? 0;
        $videoCount = ($fileExtensions['mp4'] ?? 0) + ($fileExtensions['avi'] ?? 0) + ($fileExtensions['mkv'] ?? 0);
        $wordCount = ($fileExtensions['doc'] ?? 0) + ($fileExtensions['docx'] ?? 0);
        $imageCount = ($fileExtensions['jpg'] ?? 0) + ($fileExtensions['jpeg'] ?? 0) + ($fileExtensions['png'] ?? 0) + ($fileExtensions['gif'] ?? 0) + ($fileExtensions['webp'] ?? 0);

        // --- ✨ FITUR BARU: Cek Kapasitas Storage Lokal & Kirim Notifikasi jika Penuh ---
        $diskPath = storage_path('app/public');
        if (function_exists('disk_total_space') && is_dir($diskPath)) {
            $totalSpace = disk_total_space($diskPath);
            $freeSpace = disk_free_space($diskPath);
            if ($totalSpace > 0) {
                $usedPercentage = (($totalSpace - $freeSpace) / $totalSpace) * 100;
                
                // Jika kapasitas > 90%, kirim notifikasi ke admin
                if ($usedPercentage > 90) {
                    // Cek duplikasi (jika notifikasi belum dibaca, jangan spam)
                    $existing = Notification::where('type', 'System')
                        ->where('is_read', false)
                        ->where('title', 'like', '%Storage Lokal Hampir Penuh%')
                        ->first();

                    if (!$existing) {
                        Notification::create([
                            'user_id' => null, // Notifikasi untuk semua admin
                            'article_id' => null,
                            'type' => 'System',
                            'title' => '⚠️ Storage Lokal Hampir Penuh',
                            'message' => "Kapasitas penyimpanan server (direktori public) telah mencapai " . round($usedPercentage, 2) . "%. Segera lakukan reklamasi file orphan atau bersihkan file tidak terpakai!",
                            'url' => route('admin.storage'),
                            'is_read' => false,
                        ]);
                    }
                }
            }
        }

        return view('admin-storage', compact(
            'laravelSize', 'totalFileCount',
            'pdfCount', 'videoCount', 'wordCount', 'imageCount',
            'topFiles', 'orphanFilesDisplay', 'orphanFiles'
        ));
    }

    /**
     * Menghapus file spesifik (Dari tombol Hapus di Daftar File Orphan)
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
     * Scan & Cleanup (Menghapus semua file orphan)
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
                $usedPaths[] = $src;
            }
            
            preg_match_all('/href="([^"]*)"/', $article->content, $hrefMatches);
            foreach ($hrefMatches[1] as $href) {
                if (preg_match('/\.(pdf|doc|docx|zip|jpg|png|jpeg)$/i', $href)) {
                    $usedPaths[] = $href;
                }
            }
        }
        $usedPaths = array_unique(array_filter($usedPaths));

        $deletedCount = 0;
        foreach ($allFiles as $file) {
            if (str_starts_with(basename($file), '.')) continue;

            $isUsed = false;
            $normalizedFile = $this->normalizePath($file);
            foreach ($usedPaths as $usedPath) {
                $normalizedUsed = $this->normalizePath($usedPath);
                if ($normalizedFile === $normalizedUsed || str_ends_with($normalizedUsed, '/' . $normalizedFile)) {
                    $isUsed = true;
                    break;
                }
            }

            if (!$isUsed) {
                $disk->delete($file);
                $deletedCount++;
            }
        }

        return back()->with('success', "Reklamasi selesai! Sebanyak {$deletedCount} file orphan telah dihapus.");
    }

    /**
     * HELPER: Normalisasi path file agar konsisten antara database dan physical disk.
     */
    private function normalizePath($path)
    {
        $path = trim($path);
        // Hapus protokol dan domain jika ada URL lengkap
        if (preg_match('/^https?:\/\//', $path)) {
            $parsed = parse_url($path);
            $path = $parsed['path'] ?? '';
        }
        // Hapus prefix /storage/ atau storage/ atau public/
        $path = preg_replace('#^(/storage/|storage/|public/)#', '', $path);
        // Hapus querystring jika ada (misal ?v=1)
        if (($pos = strpos($path, '?')) !== false) {
            $path = substr($path, 0, $pos);
        }
        return ltrim($path, '/');
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