<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        // Mengambil semua feedback beserta relasi article dan user
        $feedbacks = Feedback::with(['article.user', 'user'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('admin-feedback', compact('feedbacks'));
    }

    // Untuk CRUD (Update Status/Reply/Assign)
    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        
        // Validasi aksi yang dikirim dari dropdown
        $action = $request->input('action');

        switch ($action) {
            case 'assign':
                $feedback->status = 'Assigned';
                break;
            case 'close':
                $feedback->status = 'Closed';
                break;
            case 'resolve':
                $feedback->status = 'Resolved';
                break;
            case 'revision':
                $feedback->status = 'In Progress';
                // Di sini Anda bisa menambahkan logika untuk notifikasi penulis
                break;
            default:
                return back()->with('error', 'Aksi tidak dikenali.');
        }

        $feedback->save();

        return redirect()->route('admin.feedback')->with('success', 'Status feedback berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback')->with('success', 'Feedback berhasil dihapus.');
    }
}