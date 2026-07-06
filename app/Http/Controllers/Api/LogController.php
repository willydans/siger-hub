<?php

// FILE: app/Http/Controllers/Api/LogController.php
// Search logs & Activity logs untuk admin monitoring

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SearchLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    use ApiResponse;

    // ── GET /api/v1/admin/logs/search ─────────────────────────────
    // Riwayat lengkap semua pencarian yang pernah dilakukan
    public function searchLogs(Request $request): JsonResponse
    {
        // PERBAIKAN 1: Hapus parameter 'searched_at' di latest(), 
        // biarkan kosong agar otomatis menggunakan 'created_at'
        $query = SearchLog::with('user:id,name,email')
            ->latest();

        // Filter keyword
        if ($request->filled('keyword')) {
            $query->where('keyword', 'like', '%' . $request->keyword . '%');
        }

        // Filter hanya yang tidak menemukan hasil
        if ($request->boolean('no_results')) {
            $query->where('result_count', 0);
        }

        // Filter periode
        $period = $request->get('period', 'all');
        // PERBAIKAN 2: Ubah 'searched_at' menjadi 'created_at' pada query filter waktu
        if ($period === 'week') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($period === 'month') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        $logs = $query->paginate($request->get('per_page', 20));

        return $this->success([
            'items' => $logs->map(fn ($log) => [
                'id'           => $log->id,
                'keyword'      => $log->keyword,
                'result_count' => $log->result_count,
                'user'         => $log->user ? [
                    'id'    => $log->user->id,
                    'name'  => $log->user->name,
                    'email' => $log->user->email,
                ] : null, // null = dicari oleh guest
                'ip_address'  => $log->ip_address,
                // PERBAIKAN 3: Ambil value dari 'created_at' 
                // (Key JSON tetap dipertahankan 'searched_at' agar tidak merusak frontend)
                // Ubah menjadi seperti ini:
'searched_at' => \Carbon\Carbon::parse($log->created_at)->toDateTimeString(),
            ]),
            'current_page' => $logs->currentPage(),
            'last_page'    => $logs->lastPage(),
            'total'        => $logs->total(),
        ]);
    }

    // ── GET /api/v1/admin/logs/activity ───────────────────────────
    // Log aktivitas sistem dari Spatie Activity Log
    public function activityLogs(Request $request): JsonResponse
    {
        $query = Activity::with('causer:id,name,email')
            ->latest();

        // Filter by tipe log (event name)
        if ($request->filled('log_name')) {
            $query->where('event', $request->log_name);
        }

        // Filter by user tertentu
        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id)
                  ->where('causer_type', 'App\Models\User');
        }

        // Filter periode
        $period = $request->get('period', 'all');
        if ($period === 'week') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($period === 'month') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        $logs = $query->paginate($request->get('per_page', 20));

        return $this->success([
            'items' => $logs->map(fn ($log) => [
                'id'          => $log->id,
                'action'      => $log->description,
                'subject'     => $log->subject_type ? class_basename($log->subject_type) : null,
                'subject_id'  => $log->subject_id,
                'properties'  => $log->properties,
                'causer'      => $log->causer ? [
                    'id'    => $log->causer->id,
                    'name'  => $log->causer->name,
                    'email' => $log->causer->email,
                ] : null,
                'created_at'  => \Carbon\Carbon::parse($log->created_at)->toDateTimeString(),
            ]),
            'current_page' => $logs->currentPage(),
            'last_page'    => $logs->lastPage(),
            'total'        => $logs->total(),
        ]);
    }

    // ── GET /api/v1/admin/logs/activity/types ─────────────────────
    // Daftar tipe aksi yang tersedia (untuk filter dropdown di frontend)
    public function activityTypes(): JsonResponse
    {
        $types = Activity::selectRaw('description, COUNT(*) as count')
            ->groupBy('description')
            ->orderByDesc('count')
            ->get()
            ->map(fn ($t) => [
                'action' => $t->description,
                'count'  => $t->count,
            ]);

        return $this->success($types);
    }
}