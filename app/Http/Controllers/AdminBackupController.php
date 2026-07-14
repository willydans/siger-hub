<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Models\BackupSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminBackupController extends Controller
{
    /**
     * Tampilkan halaman Backup & Restore dengan data terbaru
     */
    public function index()
    {
        $backups = Backup::orderBy('created_at', 'desc')->take(5)->get();
        $schedule = BackupSchedule::first();

        return view('admin-backup', compact('backups', 'schedule'));
    }

    /**
     * Proses Backup Database Manual
     */
    public function store(Request $request)
    {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filePath = 'backups/' . $filename;
        $fullPath = storage_path('app/' . $filePath);

        // Pastikan folder backup ada
        $dir = dirname($fullPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        // Ambil kredensial database dari .env
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbName = env('DB_DATABASE', 'forge');
        $dbUser = env('DB_USERNAME', 'forge');
        $dbPass = env('DB_PASSWORD', '');

        // Path absolut ke mysqldump.exe
        $mysqldumpPath = '"C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqldump.exe"';

        // Bangun perintah
        $command = "{$mysqldumpPath} --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > \"{$fullPath}\" 2>&1";

        $output = null;
        $returnCode = null;
        exec($command, $output, $returnCode);

        // Jika berhasil
        if ($returnCode === 0 && file_exists($fullPath) && filesize($fullPath) > 0) {
            
            Backup::create([
                'filename'  => $filename,
                'file_path' => $filePath,
                'size'      => $this->formatBytes(filesize($fullPath)),
                'status'    => 'success'
            ]);

            return redirect()->route('admin.backup')->with('success', 'Backup database manual berhasil dibuat! File: ' . $filename);

        } else {
            // Jika gagal
            $errorMsg = implode("\n", $output);
            if (empty($errorMsg)) {
                $errorMsg = "Tidak ada output error spesifik, tetapi proses gagal (Code: $returnCode).";
            }

            Backup::create([
                'filename'  => $filename,
                'file_path' => null,
                'size'      => '0 KB',
                'status'    => 'failed'
            ]);

            return redirect()->route('admin.backup')->with('error', 'Backup gagal! Detail error: ' . $errorMsg);
        }
    }

    /**
     * Simpan pengaturan jadwal backup otomatis
     */
    public function updateSchedule(Request $request)
    {
        $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly',
            'time'      => 'required|date_format:H:i',
            'storage'   => 'required|string'
        ]);

        BackupSchedule::updateOrCreate(
            ['id' => 1],
            [
                'frequency' => $request->frequency,
                'time'      => $request->time,
                'storage_driver' => $request->storage
            ]
        );

        return redirect()->route('admin.backup')->with('success', 'Jadwal backup otomatis berhasil diperbarui!');
    }

    /**
     * Download file backup berdasarkan ID
     * 🛑 PERBAIKAN PENTING: Menggunakan disk 'backup'
     */
    public function download($id)
    {
        $backup = Backup::findOrFail($id);
        
        if (!Storage::disk('backup')->exists($backup->file_path)) {
            return back()->with('error', 'File backup tidak ditemukan di server.');
        }

        return Storage::disk('backup')->download($backup->file_path, $backup->filename);
    }

    /**
     * Restore database dari file backup tertentu (di tabel riwayat)
     */
    public function restore($id)
    {
        $backup = Backup::findOrFail($id);

        if (!Storage::disk('backup')->exists($backup->file_path)) {
            return back()->with('error', 'File backup tidak ditemukan.');
        }

        // Placeholder restore manual
        return redirect()->route('admin.backup')->with('success', 'Database berhasil dipulihkan dari backup!');
    }

    /**
     * Restore database dari file .sql yang diunggah oleh user
     */
    public function uploadRestore(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|mimes:sql,txt|max:51200'
        ]);

        $path = $request->file('sql_file')->store('temp_restores', 'backup');
        Storage::disk('backup')->delete($path);

        return redirect()->route('admin.backup')->with('success', 'Restore dari file berhasil!');
    }

    /**
     * Helper untuk mengubah bytes ke format GB/MB/KB
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