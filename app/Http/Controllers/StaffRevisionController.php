<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class StaffRevisionController extends Controller
{
    // Menampilkan daftar artikel yang statusnya 'revision'
    public function index()
    {
        $revisions = Article::with('reviewedBy') // Asumsi relasi 'reviewedBy' ke User
            ->where('user_id', auth()->id())
            ->where('status', 'revision')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('staff-revision', compact('revisions'));
    }

    // Mengambil data detail revisi via AJAX untuk Modal
    public function getDetails($id)
    {
        $article = Article::with('reviewedBy')
            ->where('user_id', auth()->id())
            ->where('status', 'revision')
            ->findOrFail($id);

        // Decode JSON jika ada, jika error/null jadikan array kosong
        $notes = json_decode($article->revision_notes, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($notes)) {
            $notes = [];
        }

        return response()->json([
            'id'     => $article->id,
            'title'  => $article->title,
            'date'   => $article->updated_at->format('d M Y'),
            'admin'  => optional($article->reviewedBy)->name ?? 'Admin',
            'status' => 'Revision',
            'notes'  => $notes 
        ]);
    }

    // Mengirim ulang draft yang sudah diperbaiki ke Admin
    public function submitAgain($id)
    {
        $article = Article::where('user_id', auth()->id())
            ->where('status', 'revision')
            ->findOrFail($id);

        $article->status = 'pending';
        $article->save();

        return redirect()->back()->with('success', 'Artikel berhasil dikirim ulang untuk review.');
    }
}