<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserActivity;
use App\Models\Notification; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffDraftController extends Controller
{
    /**
     * Menampilkan daftar draft milik staff yang sedang login
     */
    public function index()
    {
        $userId = auth()->id();
        
        $drafts = Article::where('user_id', $userId)
            ->where('status', 'draft')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('staff-draft', compact('drafts'));
    }

    /**
     * Menghapus draft (Soft Delete)
     */
    public function destroy($id)
    {
        $article = Article::where('user_id', auth()->id())
            ->where('status', 'draft')
            ->findOrFail($id);
        
        $title = $article->title;
        $article->delete();

        // Catat aktivitas hapus draft
        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $id,
            'type'       => 'Hapus Draft',
            'description'=> 'Menghapus draft: ' . $title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Draft "' . $title . '" berhasil dihapus.');
    }

    /**
     * Mengirim draft ke Admin untuk review (Ubah status menjadi 'pending')
     * ✨ Sekaligus mengirim notifikasi ke Admin.
     */
    public function submit($id)
    {
        $article = Article::where('user_id', auth()->id())
            ->where('status', 'draft')
            ->findOrFail($id);
        
        $article->status = 'pending';
        $article->save();

        // Catat aktivitas submit draft
        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Submit Draft',
            'description'=> 'Mengirim draft ke admin untuk review: ' . $article->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // ==========================================
        // ✨ FITUR BARU: Kirim Notifikasi ke Admin
        // ==========================================
        Notification::create([
            'user_id'    => null, // Null berarti notifikasi untuk semua Admin (sesuai logika sistem notifikasi sebelumnya)
            'article_id' => $article->id,
            'type'       => 'Approval',
            'title'      => '📝 Draft Baru Dikirim untuk Review',
            'message'    => 'Staff ' . auth()->user()->name . ' telah mengirimkan draft berjudul "' . $article->title . '" untuk diperiksa dan disetujui.',
            'url'        => route('admin.pending-approval'), // Tautan langsung ke halaman Pending Approval Admin
            'is_read'    => false,
        ]);

        return redirect()->back()->with('success', 'Draft "' . $article->title . '" berhasil dikirim untuk review.');
    }

    /**
     * Mengarahkan user ke halaman Editor Lengkap untuk mengedit draft
     */
    public function edit($id)
    {
        return redirect()->route('staff.editor.edit', ['id' => $id]);
    }

    /**
     * Menampilkan preview draft (dengan deteksi video)
     */
    public function preview($id)
    {
        $article = Article::where('user_id', auth()->id())
            ->where('status', 'draft')
            ->findOrFail($id);
        
        $hasVideo = false;
        $attachments = $article->attachments;

        if (is_string($attachments)) {
            $attachments = json_decode($attachments, true);
        }

        if (is_array($attachments)) {
            foreach ($attachments as $path) {
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'mkv', 'webm'])) {
                    $hasVideo = true;
                    break;
                }
            }
        }

        return view('staff-draft-preview', compact('article', 'hasVideo'));
    }
}