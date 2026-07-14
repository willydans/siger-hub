<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Opd;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    /**
     * Menampilkan daftar artikel dengan filter dan sorting.
     */
    public function index(Request $request, $status = null)
    {
        $query = Article::with('user')->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        // Filter pencarian dan dropdown
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('opd')) {
            $query->where('opd_unit', $request->opd);
        }
        if ($request->filled('author')) {
            $query->where('user_id', $request->author);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('visibility')) {
            $query->where('visibility', $request->visibility);
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('version')) {
            $query->where('version', $request->version);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'rating') {
            $query->orderBy('rating_avg', 'desc');
        } elseif ($sort === 'views') {
            $query->orderBy('views', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $articles = $query->paginate(10)->appends($request->except('page'));

        // Data untuk dropdown filter
        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $opds = Opd::orderBy('name')->get();

        // Menentukan judul dan view berdasarkan status
        $pageTitle = 'All Articles';
        $statusLabel = 'Semua artikel';
        $viewFile = 'admin-all-articles';

        if ($status) {
            $labelMap = [
                'pending'   => 'Pending Approval',
                'draft'     => 'Draft',
                'revision'  => 'Revision',
                'published' => 'Published',
                'archived'  => 'Archived',
                'deleted'   => 'Deleted'
            ];
            $statusLabel = $labelMap[$status] ?? ucfirst($status);
            $pageTitle = $statusLabel . ' Articles';
            // Jika status pending, kita gunakan view khusus
            if ($status === 'pending') {
                $viewFile = 'admin-pending-approval';
            }
        }

        return view($viewFile, compact('articles', 'users', 'categories', 'opds', 'status', 'pageTitle', 'statusLabel'));
    }

    /**
     * Mengambil data artikel untuk keperluan edit via AJAX.
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    /**
     * Memperbarui data artikel (judul, kategori, status, visibility, versi).
     * Menambahkan logika otomatis isi published_at jika status berubah menjadi published.
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->only(['title', 'category', 'status', 'visibility', 'version']);

        // ✨ Jika status diubah menjadi 'published' dan published_at kosong, isi otomatis
        if ($request->has('status') && $request->status === 'published' && is_null($article->published_at)) {
            $data['published_at'] = now();
        }

        $article->update($data);
        return redirect()->route('admin.all-articles')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Menghapus artikel (soft delete).
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('admin.all-articles')->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Menyetujui artikel (ubah status dari pending menjadi published).
     * ✨ PERBAIKAN UTAMA: Otomatis mengisi published_at jika kosong.
     */
    public function approve($id)
    {
        $article = Article::findOrFail($id);
        
        $data = ['status' => 'published'];
        if (is_null($article->published_at)) {
            $data['published_at'] = now();
        }
        
        $article->update($data);

        // Catat activity log
        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => 'Artikel disetujui oleh admin',
            'properties'   => json_encode(['old_status' => 'pending', 'new_status' => 'published']),
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil disetujui dan dipublikasikan.');
    }

    /**
     * Menolak artikel (ubah status menjadi revision).
     */
    public function reject($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['status' => 'revision']);
        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => 'Artikel ditolak oleh admin',
            'properties'   => json_encode(['old_status' => 'pending', 'new_status' => 'revision']),
        ]);
        return redirect()->back()->with('success', 'Artikel ditolak dan dikembalikan ke revisi.');
    }

    /**
     * Mengarsipkan artikel.
     */
    public function archive($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['status' => 'archived']);
        return redirect()->back()->with('success', 'Artikel berhasil diarsipkan.');
    }

    /**
     * Memulihkan artikel dari arsip (kembali ke draft).
     */
    public function restore($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $article->restore();
        $article->status = 'draft';
        $article->save();

        return redirect()->route('admin.all-articles')->with('success', 'Artikel berhasil dipulihkan!');
    }

    /**
     * Menduplikasi artikel menjadi draft baru.
     */
    public function duplicate($id)
    {
        $original = Article::findOrFail($id);
        
        $new = $original->replicate();
        $new->title = $original->title . ' (Copy)';
        $new->slug = Str::slug($new->title) . '-' . uniqid();
        $new->status = 'draft';
        $new->views = 0;
        $new->save();

        return redirect()->back()->with('success', 'Artikel berhasil diduplikasi.');
    }

    /**
     * Menampilkan detail artikel di halaman Admin.
     */
    public function show($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Menampilkan riwayat perubahan spesifik untuk artikel tersebut.
     */
    public function history($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        
        $history = ActivityLog::where('subject_id', $id)
                    ->where('subject_type', 'App\Models\Article')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.articles.history', compact('article', 'history'));
    }

    /**
     * Mengambil data artikel dalam format JSON untuk modal review.
     */
    public function getArticleJson($id)
    {
        $article = Article::with('user')->findOrFail($id);
        return response()->json($article);
    }

    /**
     * Mengirim permintaan revisi (catatan revisi)
     */
    public function revision(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $note = $request->input('note', '');
        // Update status menjadi revision
        $article->update(['status' => 'revision']);
        // Catat activity log dengan catatan revisi
        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => 'Admin meminta revisi: ' . $note,
            'properties'   => json_encode(['note' => $note]),
        ]);
        return response()->json(['message' => 'Permintaan revisi berhasil dikirim']);
    }
}