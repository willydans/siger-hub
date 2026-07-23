<?php

namespace App\Http\Controllers;

use App\Models\SearchLog;
use App\Models\User;
use App\Models\Article;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminSearchLogController extends Controller
{
    public function index(Request $request)
    {
        // --- 1. Statistik Kartu Ringkasan ---
        $totalSearch = SearchLog::count();
        $todaySearch = SearchLog::whereDate('created_at', Carbon::today())->count();
        $activeUsers = SearchLog::whereNotNull('user_id')->distinct('user_id')->count('user_id');
        $newKeywords = SearchLog::distinct('query')->count('query');

        // --- 2. Data Grafik Trend (Top 5 Keyword) ---
        $trendData = SearchLog::selectRaw('query, count(*) as total')
            ->groupBy('query')
            ->orderByDesc('total')
            ->take(5)
            ->get();
        $trendLabels = $trendData->pluck('query');
        $trendValues = $trendData->pluck('total');

        // --- 3. Tabel Search History (Pagination) ---
        $history = SearchLog::with('user.role')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // --- 4. Keyword Tanpa Hasil (Zero Results) ---
        $zeroResults = SearchLog::with('user')
            ->where('results_count', 0)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // --- 5. Search Berdasarkan OPD ---
        $opdData = SearchLog::join('users', 'search_logs.user_id', '=', 'users.id')
            ->whereNotNull('users.opd')
            ->select('users.opd', 'search_logs.query')
            ->groupBy('users.opd', 'search_logs.query')
            ->orderByRaw('users.opd, count(*) desc')
            ->get()
            ->groupBy('opd');

        // --- 6. Search Berdasarkan Role ---
        $roleData = SearchLog::join('users', 'search_logs.user_id', '=', 'users.id')
            ->join('model_has_roles', function($join) {
                // Sambungkan user dengan tabel perantara Spatie
                $join->on('users.id', '=', 'model_has_roles.model_id')
                     ->where('model_has_roles.model_type', \App\Models\User::class);
            })
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id') // Baru sambungkan ke roles
            ->select('roles.name as role', DB::raw('count(*) as total'))
            ->groupBy('roles.name')
            ->orderByDesc('total')
            ->get();

        // --- 7. Search Berdasarkan Device ---
        $deviceData = [
            'Mobile' => SearchLog::where('user_agent', 'like', '%Mobile%')->count(),
            'Desktop' => SearchLog::where('user_agent', 'not like', '%Mobile%')
                ->where('user_agent', 'not like', '%Tablet%')->count(),
            'Tablet' => SearchLog::where('user_agent', 'like', '%Tablet%')->count(),
        ];

        // --- 8. Search Success Rate ---
        $successCount = SearchLog::where('results_count', '>', 0)->count();
        $failCount = SearchLog::where('results_count', 0)->count();
        $totalCount = $successCount + $failCount;

        // --- 9. Search Analytics Table ---
        $analytics = SearchLog::selectRaw('
                query, 
                count(*) as search_count, 
                sum(clicks) as total_clicks,
                max(clicked_article_id) as last_article_id
            ')
            ->groupBy('query')
            ->orderByDesc('search_count')
            ->take(5)
            ->get();

        foreach ($analytics as $item) {
            $item->ctr = $item->search_count > 0 ? round(($item->total_clicks / $item->search_count) * 100) : 0;
            $item->article_title = $item->last_article_id 
                ? (Article::find($item->last_article_id)->title ?? '-') 
                : '-';
        }

        return view('admin-searchlog', compact(
            'totalSearch', 'todaySearch', 'activeUsers', 'newKeywords',
            'trendData', 'trendLabels', 'trendValues',
            'history', 'zeroResults', 'opdData', 'roleData', 'deviceData',
            'successCount', 'failCount', 'totalCount', 'analytics'
        ));
    }

    /**
     * Menugaskan staff untuk membuat artikel & mengirim notifikasi.
     */
    public function assign(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
            'staff_id' => 'required|exists:users,id'
        ]);

        $staff = User::find($request->staff_id);
        $keyword = $request->keyword;

        Notification::create([
            'user_id'    => $staff->id,
            'article_id' => null,
            'type'       => 'Assignment',
            'title'      => '📝 Tugas Artikel Baru dari Admin',
            'message'    => "Anda ditugaskan untuk membuat dokumentasi terkait keyword: '{$keyword}'. Silakan buka editor untuk memulai.",
            'url'        => route('staff.editor'),
            'is_read'    => false,
        ]);

        return redirect()->back()->with('success', "Artikel untuk keyword '{$keyword}' telah ditugaskan ke {$staff->name}!");
    }
}