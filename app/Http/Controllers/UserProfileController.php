<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\UserActivity;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Notifications\UserNotification;

class UserProfileController extends Controller
{
    /**
     * Menampilkan halaman Dashboard/Profil Pengguna (Single Page dengan Tabs).
     * Semua data (Stats, History, Bookmark, Notification) di-load sekaligus di sini.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Query History (Riwayat Aktivitas) dengan Filter
        $activityQuery = UserActivity::where('user_id', $user->id);
        if ($request->filled('search')) {
            $activityQuery->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('type')) {
            $activityQuery->where('type', $request->type);
        }
        if ($request->filled('date')) {
            $activityQuery->whereDate('created_at', $request->date);
        }
        
        $activities = $activityQuery->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->except('page'));

        // 2. Query Bookmark
        $bookmarks = Bookmark::where('user_id', $user->id)->with('article')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        // 3. ✅ Query Notifikasi (menggunakan relasi hasMany dari model User)
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // 4. Statistik Dashboard
        $stats = [
            'total_activities' => UserActivity::where('user_id', $user->id)->count(),
            'articles_read'    => UserActivity::where('user_id', $user->id)->where('type', 'read')->count(),
            'downloads'        => UserActivity::where('user_id', $user->id)->where('type', 'download')->count(),
            'bookmarks'        => Bookmark::where('user_id', $user->id)->count(),
            'ratings'          => UserActivity::where('user_id', $user->id)->where('type', 'rating')->count(),
            'likes'            => UserActivity::where('user_id', $user->id)->where('type', 'like')->count(),
        ];

        // 5. Data Chart (7 Hari Terakhir)
        $chartData = $this->getChartData($user->id);

        return view('user-profil', compact('user', 'activities', 'bookmarks', 'notifications', 'stats', 'chartData'));
    }

    /**
     * Helper untuk menghitung data Chart aktivitas 7 hari terakhir.
     */
    private function getChartData($userId)
    {
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = UserActivity::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();
            $days[] = $count;
        }
        return [
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'data' => $days
        ];
    }

    // ============================================================
    // PROFILE UPDATE
    // ============================================================

    /**
     * Update profil user.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:15',
            'instansi' => 'nullable|string|max:255',
            'bidang'   => 'nullable|string|max:255',
            'jabatan'  => 'nullable|string|max:255',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'instansi', 'bidang', 'jabatan'));

        return redirect()->route('user.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ganti password user.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.profil')->with('success', 'Password berhasil diubah.');
    }

    // ============================================================
    // HISTORY ACTIONS
    // ============================================================

    /**
     * Hapus satu riwayat aktivitas.
     */
    public function deleteHistory($id)
    {
        $activity = UserActivity::where('user_id', Auth::id())->findOrFail($id);
        $activity->delete();
        return redirect()->route('user.profil')->with('success', 'Aktivitas berhasil dihapus.');
    }

    /**
     * Hapus semua riwayat aktivitas user.
     */
    public function clearHistory()
    {
        UserActivity::where('user_id', Auth::id())->delete();
        return redirect()->route('user.profil')->with('success', 'Semua riwayat aktivitas telah dihapus.');
    }

    // ============================================================
    // BOOKMARK ACTIONS
    // ============================================================

    /**
     * Toggle bookmark (AJAX).
     */
    public function toggleBookmark(Request $request)
    {
        $articleId = $request->article_id;
        $user = Auth::user();
        $bookmark = Bookmark::where('user_id', $user->id)->where('article_id', $articleId)->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Bookmark::create(['user_id' => $user->id, 'article_id' => $articleId]);
            return response()->json(['status' => 'added']);
        }
    }

    /**
     * Hapus bookmark.
     */
    public function deleteBookmark($id)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->findOrFail($id);
        $bookmark->delete();
        return redirect()->route('user.profil')->with('success', 'Bookmark berhasil dihapus.');
    }

    // ============================================================
    // NOTIFICATION ACTIONS
    // ============================================================

    /**
     * Tandai satu notifikasi sebagai telah dibaca.
     */
    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect()->route('user.profil')->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai telah dibaca.
     */
    public function markAllNotificationsAsRead()
    {
        $user = Auth::user();
        // ✅ Perbaikan: gunakan query update langsung
        $user->notifications()->update(['is_read' => true]);
        return redirect()->route('user.profil')->with('success', 'Semua notifikasi telah dibaca.');
    }

    /**
     * Hapus satu notifikasi.
     */
    public function deleteNotification($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return redirect()->route('user.profil')->with('success', 'Notifikasi berhasil dihapus.');
    }

    /**
     * Hapus semua notifikasi.
     */
    public function clearNotifications()
    {
        Auth::user()->notifications()->delete();
        return redirect()->route('user.profil')->with('success', 'Semua notifikasi telah dihapus.');
    }

    // ============================================================
    // FITUR KEAMANAN (Login History, Active Devices, Logout All)
    // ============================================================

    /**
     * Menampilkan riwayat login user dalam bentuk modal (AJAX).
     *
     * ✅ PERBAIKAN: query type disamakan persis ('Login', huruf besar)
     * dengan cara AuthController/OtpController menyimpannya — sebelumnya
     * pakai 'login' huruf kecil, kebetulan masih cocok karena collation
     * default MySQL tidak case-sensitive, tapi ini rapuh dan sebaiknya
     * tidak diandalkan.
     */
    public function loginHistory(Request $request)
    {
        $activities = UserActivity::where('user_id', auth()->id())
                    ->where('type', 'Login')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return response()->json([
            'html' => view('user.modals.login-history', compact('activities'))->render()
        ]);
    }

    /**
     * Menampilkan daftar perangkat aktif user (dari tabel sessions),
     * TIDAK termasuk sesi yang sedang dipakai saat ini.
     *
     * ✅ PERBAIKAN KRUSIAL: sebelumnya query ini tidak mengecualikan sesi
     * saat ini sama sekali — padahal partial view-nya sendiri menuliskan
     * "perangkat yang sedang Anda gunakan tidak ditampilkan". Sekarang
     * benar-benar dikecualikan lewat where('id', '!=', ...).
     *
     * ✅ TAMBAHAN: dibungkus pengecekan SESSION_DRIVER — kalau .env masih
     * pakai driver selain 'database' (mis. 'file'), tabel `sessions` tidak
     * ada, dan query ini akan langsung melempar QueryException. Sekarang
     * fallback aman ke collection kosong alih-alih error 500.
     */
    public function activeDevices(Request $request)
    {
        $sessions = collect();

        if (config('session.driver') === 'database') {
            $currentSessionId = $request->session()->getId();

            $sessions = DB::table('sessions')
                        ->where('user_id', auth()->id())
                        ->where('id', '!=', $currentSessionId)
                        ->orderBy('last_activity', 'desc')
                        ->get()
                        ->map(function ($session) {
                            $session->last_activity = Carbon::createFromTimestamp($session->last_activity);
                            $session->device = $this->getDeviceInfo($session->user_agent);
                            $session->ip_address = $session->ip_address ?? '-';
                            return $session;
                        });
        }

        return response()->json([
            'html' => view('user.modals.active-devices', compact('sessions'))->render()
        ]);
    }

    /**
     * Logout dari semua perangkat (termasuk perangkat yang sedang aktif).
     *
     * ✅ PERBAIKAN: flash message diganti dari key 'status' menjadi
     * 'success', supaya konsisten dengan seluruh method lain di
     * controller ini (dan supaya tetap terlihat kalau tampilan hanya
     * mendengarkan session('success')).
     *
     * ✅ TAMBAHAN: dibungkus pengecekan SESSION_DRIVER juga, konsisten
     * dengan activeDevices().
     */
    public function logoutAllDevices(Request $request)
    {
        if (config('session.driver') === 'database') {
            $currentSessionId = $request->session()->getId();

            DB::table('sessions')
                ->where('user_id', auth()->id())
                ->where('id', '!=', $currentSessionId)
                ->delete();
        }

        // Logout sesi saat ini juga, supaya benar-benar "semua perangkat"
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout dari semua perangkat.');
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    /**
     * Mendeteksi perangkat dari User Agent.
     *
     * ✅ PERBAIKAN: null-safe — sebelumnya strpos($userAgent, ...) akan
     * melempar TypeError di PHP 8 kalau user_agent tersimpan null di
     * tabel sessions (bisa terjadi untuk sesi lama/anonim).
     */
    private function getDeviceInfo($userAgent)
    {
        $userAgent = $userAgent ?? '';

        $device = 'Unknown';
        if (strpos($userAgent, 'Mobile') !== false) {
            $device = 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false) {
            $device = 'Tablet';
        } else {
            $device = 'Desktop';
        }

        $os = 'Unknown';
        if (strpos($userAgent, 'Windows') !== false) {
            $os = 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            $os = 'Mac';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            $os = 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $os = 'Android';
        } elseif (strpos($userAgent, 'iOS') !== false) {
            $os = 'iOS';
        }

        return $device . ' - ' . $os;
    }
}