<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        // Asumsi: Feedback terhubung ke Article, dan Article memiliki relasi ke User (Penulis)
        // Kita gunakan eager loading agar query lebih ringan
        $feedbacks = Feedback::with(['article.user'])->latest()->paginate(10);
        
        return view('admin-feedback', compact('feedbacks'));
    }

    // Fungsi untuk mengubah status lewat tombol dropdown Action
    public function updateStatus(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $request->validate([
            'status' => 'required|string'
        ]);

        $feedback->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status feedback berhasil diperbarui!');
    }
}