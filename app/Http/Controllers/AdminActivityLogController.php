<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminActivityLogController extends Controller
{
    /**
     * Tampilkan halaman Activity Log dengan filter dan pagination.
     * Membatasi 10 data per halaman sesuai permintaan Anda.
     */
    public function index(Request $request)
    {
        // Query dasar dengan eager loading relasi user
        $query = UserActivity::with('user');

        // Terapkan filter menggunakan pendekatan 'when' (lebih bersih dan elegan)
        $query->when($request->filled('user'), function ($q) use ($request) {
            return $q->whereHas('user', function ($sub) use ($request) {
                $sub->where('name', 'like', '%' . $request->user . '%');
            });
        })->when($request->filled('date'), function ($q) use ($request) {
            return $q->whereDate('created_at', $request->date);
        })->when($request->filled('activity_type') && $request->activity_type !== 'Semua', function ($q) use ($request) {
            return $q->where('type', $request->activity_type);
        })->when($request->filled('ip_address'), function ($q) use ($request) {
            return $q->where('ip_address', 'like', '%' . $request->ip_address . '%');
        })->when($request->filled('device'), function ($q) use ($request) {
            return $q->where('user_agent', 'like', '%' . $request->device . '%');
        });

        // Paginate 10 data per halaman, pertahankan parameter filter di URL (appends)
        $activities = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());

        // Ambil daftar tipe aktivitas unik untuk dropdown filter
        $activityTypes = UserActivity::select('type')->distinct()->pluck('type');

        return view('admin-activity', compact('activities', 'activityTypes'));
    }

    /**
     * Ekspor ke PDF (Menggunakan DomPDF)
     */
    public function exportPdf(Request $request)
    {
        $activities = $this->getFilteredQuery($request)->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('exports.activity-pdf', compact('activities'));
        return $pdf->download('activity-log-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Ekspor ke Excel (Menggunakan format CSV native Laravel)
     */
    public function exportExcel(Request $request)
    {
        $activities = $this->getFilteredQuery($request)->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity-log-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($activities) {
            $file = fopen('php://output', 'w');
            // Tambahkan BOM (Byte Order Mark) UTF-8 agar karakter khusus di Excel terbaca dengan benar
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['Waktu', 'User', 'Aktivitas', 'IP Address', 'Device']);

            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->created_at->format('Y-m-d H:i:s'),
                    $activity->user ? $activity->user->name : 'Guest',
                    $activity->type . ' - ' . $activity->description,
                    $activity->ip_address ?? '-',
                    $activity->user_agent ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper untuk mendapatkan query dengan filter (digunakan untuk export PDF & Excel)
     */
    private function getFilteredQuery(Request $request)
    {
        $query = UserActivity::with('user');

        $query->when($request->filled('user'), function ($q) use ($request) {
            return $q->whereHas('user', function ($sub) use ($request) {
                $sub->where('name', 'like', '%' . $request->user . '%');
            });
        })->when($request->filled('date'), function ($q) use ($request) {
            return $q->whereDate('created_at', $request->date);
        })->when($request->filled('activity_type') && $request->activity_type !== 'Semua', function ($q) use ($request) {
            return $q->where('type', $request->activity_type);
        })->when($request->filled('ip_address'), function ($q) use ($request) {
            return $q->where('ip_address', 'like', '%' . $request->ip_address . '%');
        })->when($request->filled('device'), function ($q) use ($request) {
            return $q->where('user_agent', 'like', '%' . $request->device . '%');
        });

        return $query;
    }
}