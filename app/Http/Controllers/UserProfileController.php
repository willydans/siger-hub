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
    // --- Dashboard ---
    public function index()
    {
        $user = Auth::user();
        $activities = UserActivity::where('user_id', $user->id)->latest()->take(5)->get();
        $bookmarks = Bookmark::where('user_id', $user->id)->with('article')->latest()->take(3)->get();
        $notifications = $user->notifications()->latest()->take(5)->get();

        // Statistik
        $stats = [
            'total_activities' => UserActivity::where('user_id', $user->id)->count(),
            'articles_read'    => UserActivity::where('user_id', $user->id)->where('type', 'read')->count(),
            'downloads'        => UserActivity::where('user_id', $user->id)->where('type', 'download')->count(),
            'bookmarks'        => Bookmark::where('user_id', $user->id)->count(),
            'ratings'          => UserActivity::where('user_id', $user->id)->where('type', 'rating')->count(),
            'likes'            => UserActivity::where('user_id', $user->id)->where('type', 'like')->count(),
        ];

        // Data untuk chart (contoh 7 hari terakhir)
        $chartData = $this->getChartData($user->id);

        return view('user-profil', compact('user', 'activities', 'bookmarks', 'notifications', 'stats', 'chartData'));
    }

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

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
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

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    // --- History ---
    public function history(Request $request)
    {
        $user = Auth::user();
        $query = UserActivity::where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('user.history', compact('activities'));
    }

    public function deleteHistory($id)
    {
        $activity = UserActivity::where('user_id', Auth::id())->findOrFail($id);
        $activity->delete();
        return redirect()->back()->with('success', 'Aktivitas berhasil dihapus.');
    }

    public function clearHistory()
    {
        UserActivity::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Semua riwayat aktivitas telah dihapus.');
    }

    // --- Bookmark ---
    public function bookmarks(Request $request)
    {
        $user = Auth::user();
        $bookmarks = Bookmark::where('user_id', $user->id)
            ->with('article')
            ->when($request->filled('category'), function ($q) use ($request) {
                return $q->whereHas('article', function ($query) use ($request) {
                    $query->where('category', $request->category);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('user.bookmarks', compact('bookmarks'));
    }

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
        return redirect()->back()->with('success', 'Bookmark berhasil dihapus.');
    }

    // --- Notification ---
    public function notifications(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('user.notifications', compact('notifications'));
    }

    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect()->back()->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    public function markAllNotificationsAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Semua notifikasi telah dibaca.');
    }

    public function deleteNotification($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function clearNotifications()
    {
        Auth::user()->notifications()->delete();
        return redirect()->back()->with('success', 'Semua notifikasi telah dihapus.');
    }
}