<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminActivityLogController extends Controller
{
    /**
     * Tampilkan halaman Activity Log dengan filter dan pagination.
     */
    public function index(Request $request)
    {
        // Query dasar dengan eager loading user
        $query = UserActivity::with('user');

        // Filter berdasarkan user (search name)
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter berdasarkan jenis aktivitas
        if ($request->filled('activity_type') && $request->activity_type !== 'Semua') {
            $query->where('type', $request->activity_type);
        }

        // Filter berdasarkan IP Address
        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        // Filter berdasarkan Device / Browser
        if ($request->filled('device')) {
            $query->where('user_agent', 'like', '%' . $request->device . '%');
        }

        // Urutkan dari terbaru
        $activities = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());

        // Koleksi tipe aktivitas untuk dropdown (bisa diambil dari database atau static)
        $activityTypes = UserActivity::select('type')->distinct()->pluck('type');

        return view('admin-activity', compact('activities', 'activityTypes'));
    }

    /**
     * Ekspor ke PDF (Menggunakan DomPDF)
     */
    public function exportPdf(Request $request)
    {
        // Mengambil data yang sama dengan filter (tanpa pagination)
        $activities = $this->getFilteredQuery($request)->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.activity-pdf', compact('activities'));
        return $pdf->download('activity-log-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Ekspor ke Excel (Menggunakan format CSV sederhana)
     */
    public function exportExcel(Request $request)
    {
        $activities = $this->getFilteredQuery($request)->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity-log-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($activities) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Waktu', 'User', 'Aktivitas', 'IP Address', 'Device']);

            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->created_at->format('H:i'),
                    $activity->user ? $activity->user->name : 'Guest',
                    $activity->type . ' - ' . $activity->description,
                    $activity->ip_address,
                    $activity->user_agent,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper untuk mendapatkan query dengan filter (digunakan untuk export)
     */
    private function getFilteredQuery(Request $request)
    {
        $query = UserActivity::with('user');

        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('activity_type') && $request->activity_type !== 'Semua') {
            $query->where('type', $request->activity_type);
        }
        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }
        if ($request->filled('device')) {
            $query->where('user_agent', 'like', '%' . $request->device . '%');
        }

        return $query;
    }
}