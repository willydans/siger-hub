<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Tampilkan halaman Notification dengan filter kategori dan pagination.
     */
    public function index(Request $request)
    {
        // Ambil filter type dari request, default 'Semua'
        $type = $request->input('type', 'Semua');

        // Query notifikasi, urutkan dari yang terbaru
        $query = Notification::with(['user', 'article'])->orderBy('created_at', 'desc');

        // Filter berdasarkan tipe jika bukan 'Semua'
        if ($type !== 'Semua') {
            $query->where('type', $type);
        }

        $notifications = $query->paginate(10);

        return view('admin-notification', compact('notifications', 'type'));
    }

    /**
     * Menandai satu notifikasi sebagai sudah dibaca.
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notifikasi telah ditandai sebagai sudah dibaca.');
    }

    /**
     * Menandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }

    /**
     * Menghapus notifikasi.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notifikasi telah dihapus.');
    }
}