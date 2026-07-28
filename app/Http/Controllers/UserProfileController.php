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
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
        // Filter kategori dilakukan 100% oleh JS di frontend.
        $bookmarks = Bookmark::where('user_id', $user->id)->with('article')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        // 3. Query Notifikasi (Dikembalikan menggunakan \App\Models\Notification agar tidak error)
        $notifications = \App\Models\Notification::where('user_id', $user->id)
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

    public function deleteHistory($id)
    {
        $activity = UserActivity::where('user_id', Auth::id())->findOrFail($id);
        $activity->delete();
        return redirect()->route('user.profil')->with('success', 'Aktivitas berhasil dihapus.');
    }

    public function clearHistory()
    {
        UserActivity::where('user_id', Auth::id())->delete();
        return redirect()->route('user.profil')->with('success', 'Semua riwayat aktivitas telah dihapus.');
    }

    // ============================================================
    // BOOKMARK ACTIONS
    // ============================================================

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

    public function deleteBookmark($id)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->findOrFail($id);
        $bookmark->delete();
        return redirect()->route('user.profil')->with('success', 'Bookmark berhasil dihapus.');
    }

    // ============================================================
    // NOTIFICATION ACTIONS
    // ============================================================

    public function markNotificationAsRead($id)
    {
        // Menggunakan model Notification langsung agar tidak error relasi
        $notification = \App\Models\Notification::where('user_id', Auth::id())->findOrFail($id);
        
        if (isset($notification->is_read)) {
             $notification->update(['is_read' => true]);
        } elseif (method_exists($notification, 'markAsRead')) {
             $notification->markAsRead();
        }
        
        return redirect()->route('user.profil')->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    public function markAllNotificationsAsRead()
    {
        // Update langsung via model untuk menghindari error relasi
        \App\Models\Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        
        return redirect()->route('user.profil')->with('success', 'Semua notifikasi telah dibaca.');
    }

    public function deleteNotification($id)
    {
        // Menggunakan model Notification langsung agar tidak error relasi
        $notification = \App\Models\Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->delete();
        
        return redirect()->route('user.profil')->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function clearNotifications()
    {
        // Menggunakan model Notification langsung agar tidak error relasi
        \App\Models\Notification::where('user_id', Auth::id())->delete();
        return redirect()->route('user.profil')->with('success', 'Semua notifikasi telah dihapus.');
    }

    // ============================================================
    // FITUR KEAMANAN (Login History, Active Devices, Logout All)
    // ============================================================

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

    public function logoutAllDevices(Request $request)
    {
        if (config('session.driver') === 'database') {
            $currentSessionId = $request->session()->getId();

            DB::table('sessions')
                ->where('user_id', auth()->id())
                ->where('id', '!=', $currentSessionId)
                ->delete();
        }

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout dari semua perangkat.');
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

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