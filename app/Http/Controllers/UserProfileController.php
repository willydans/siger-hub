<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\UserActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        
        // Paginate & pertahankan Query String agar saat pindah halaman filter tetap berlaku
        $activities = $activityQuery->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->except('page'));

        // 2. Query Bookmark (FILTER KATEGORI DIPINDAHKAN KE JAVASCRIPT)
        // Kita hanya ambil semua data bookmark user. Filter kategori dilakukan 100% oleh JS di frontend.
        $bookmarks = Bookmark::where('user_id', $user->id)->with('article')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            // Catatan: `->appends()` dihapus karena JS menangani filter tanpa memerlukan parameter URL,
            // sehingga pagination tidak akan pernah kehilangan data.

        // 3. Query Notifikasi (Paling baru di atas)
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

        // Return ke view user-profil (sesuai file blade kamu)
        return view('user-profil', compact('user', 'activities', 'bookmarks', 'notifications', 'stats', 'chartData'));
    }

    /**
     * Helper untuk menghitung data Chart aktivitas 7 hari terakhir.
     */
    private function getChartData($userId)
    {
        $days = [];
        // 7 hari ke belakang (dari hari ini)
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = UserActivity::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();
            $days[] = $count;
        }
        return [
            // Label bisa disesuaikan format tanggalnya menjadi 'Senin, Selasa' dll.
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'data' => $days
        ];
    }

    // --- Profile Update (Informasi Akun) ---
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'instansi' => 'nullable|string|max:255',
            'bidang'   => 'nullable|string|max:255',
            'jabatan'  => 'nullable|string|max:255',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'instansi', 'bidang', 'jabatan'));

        return redirect()->route('user.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    // --- Ganti Password ---
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

    // --- History Actions ---
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

    // --- Bookmark Actions (Controller hanya handle Hapus) ---
    // Catatan: Fungsi toggleBookmark bisa digunakan untuk API jika nanti mau bikin tombol bookmark di halaman artikel.
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

    // --- Notification Actions ---
    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect()->route('user.profil')->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    public function markAllNotificationsAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('user.profil')->with('success', 'Semua notifikasi telah dibaca.');
    }

    public function deleteNotification($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return redirect()->route('user.profil')->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function clearNotifications()
    {
        Auth::user()->notifications()->delete();
        return redirect()->route('user.profil')->with('success', 'Semua notifikasi telah dihapus.');
    }
}