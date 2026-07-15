<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffNotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $user = Auth::user();

        $query = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($filter === 'today') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($filter === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        $notifications = $query->paginate(10);

        return view('staff-notification', compact('notifications', 'filter'));
    }

    public function markAsRead($id)
    {
        try {
            $notification = Notification::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();
            $notification->update(['is_read' => true]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        $notification->delete();
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}