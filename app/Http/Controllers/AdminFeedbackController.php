<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Notification; // ✅ Import model Notification
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['article.user', 'user'])
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);

        return view('admin-feedback', compact('feedbacks'));
    }

    /**
     * Update status feedback dan kirim notifikasi ke penulis jika diperlukan.
     */
    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $action = $request->input('action');

        // Simpan status lama untuk cek perubahan (opsional)
        $oldStatus = $feedback->status;

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
                break;
            default:
                return back()->with('error', 'Aksi tidak dikenali.');
        }

        $feedback->save();

        // ============================================================
        // ✨ KIRIM NOTIFIKASI KE PENULIS (STAFF) SAAT DITUGASKAN ATAU DIMINTA REVISI
        // ============================================================
        $article = $feedback->article;
        if ($article && $article->user_id) {
            $author = $article->user; // Staff penulis artikel
            $url = route('staff.editor.edit', $article->id); // Arahkan ke editor

            if ($action === 'assign') {
                Notification::create([
                    'user_id'    => $article->user_id,
                    'article_id' => $article->id,
                    'type'       => 'Assignment',
                    'title'      => '📝 Tugas Baru: Tindak Lanjut Feedback',
                    'message'    => "Admin telah menugaskan Anda untuk menindaklanjuti feedback dari pengguna pada artikel '{$article->title}'. Silakan perbaiki atau tanggapi.",
                    'url'        => $url,
                    'is_read'    => false,
                ]);
            } elseif ($action === 'revision') {
                Notification::create([
                    'user_id'    => $article->user_id,
                    'article_id' => $article->id,
                    'type'       => 'Revision',
                    'title'      => '🔄 Permintaan Revisi dari Admin',
                    'message'    => "Admin meminta revisi pada artikel '{$article->title}' berdasarkan feedback yang diterima. Segera lakukan perbaikan.",
                    'url'        => $url,
                    'is_read'    => false,
                ]);
            }
        }

        return redirect()->route('admin.feedback')->with('success', 'Status feedback berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback')->with('success', 'Feedback berhasil dihapus.');
    }
}