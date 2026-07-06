<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StaffArticleController extends Controller
{
    /**
     * Menampilkan list artikel dengan filter, search, sorting & pagination
     */
    public function index(Request $request)
    {
        $userId = auth()->id();

        $allowedSortColumns = ['created_at', 'rating', 'views', 'title'];
        $allowedSortDirs = ['asc', 'desc'];

        $sortBy = in_array($request->sort_by, $allowedSortColumns) ? $request->sort_by : 'created_at';
        $sortDir = in_array($request->sort_dir, $allowedSortDirs) ? $request->sort_dir : 'desc';

        $articles = Article::where('user_id', $userId)
            ->when($request->filled('q'), function ($query) use ($request) {
                return $query->where('title', 'like', "%{$request->q}%");
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                return $query->where('category', $request->category);
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                return $query->where('tags', 'like', "%{$request->tag}%"); // Tag biasanya disimpan sebagai JSON/string
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->filled('visibility'), function ($query) use ($request) {
                return $query->where('visibility', $request->visibility);
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                return $query->whereDate('created_at', $request->date);
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->except('page'));

        return view('staff-articles', compact('articles'));
    }

    // --- Method tampilan (show, preview, history) ---

    public function show($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        return view('staff-articles-show', compact('article'));
    }

    public function preview($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        return view('staff-articles-preview', compact('article'));
    }

    public function history($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        return view('staff-articles-history', compact('article'));
    }

    // --- Method aksi (quickUpdate, duplicate, archive, unarchive, destroy, bulk) ---

    public function quickUpdate(Request $request, $id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        // ✅ PERBAIKAN UTAMA: Sesuaikan Rule visibility dengan nilai di database (public, internal, restricted, private)
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|string|max:100',
            'visibility' => ['required', Rule::in(['public', 'internal', 'restricted', 'private'])],
        ]);

        $article->update($validated);

        // Catat aktivitas Edit Cepat Artikel
        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Edit Cepat Artikel',
            'description'=> 'Quick edit artikel: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Artikel berhasil diperbarui!');
    }

    public function duplicate($id)
    {
        $original = Article::where('user_id', auth()->id())->findOrFail($id);
        $newArticle = $original->replicate();
        $newArticle->title = $original->title . ' (Copy)';
        $newArticle->status = 'draft';
        $newArticle->views = 0;
        $newArticle->rating = 0;
        $newArticle->created_at = now();
        $newArticle->save();

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $newArticle->id,
            'type'       => 'Duplikasi Artikel',
            'description'=> 'Menduplikasi artikel dari: ' . $original->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Berhasil menduplikasi artikel!');
    }

    public function archive($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $article->update(['status' => 'archived']);

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Arsipkan Artikel',
            'description'=> 'Mengarsipkan artikel: ' . $article->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Artikel berhasil diarsipkan!');
    }

    public function unarchive($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $article->update(['status' => 'draft']);

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Kembalikan Artikel',
            'description'=> 'Mengembalikan artikel dari arsip: ' . $article->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Artikel berhasil dikembalikan ke Draft!');
    }

    public function destroy($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $title = $article->title; // Simpan judul sebelum dihapus

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Hapus Artikel',
            'description'=> 'Menghapus artikel: ' . $title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'selected_ids'   => 'required|array|min:1',
            'selected_ids.*' => 'exists:articles,id',
            'bulk_action'    => 'required|in:delete,archive,unarchive',
        ]);

        $articles = Article::where('user_id', auth()->id())
            ->whereIn('id', $request->selected_ids);

        if ($request->bulk_action === 'delete') {
            $ids = $articles->pluck('id');
            Article::destroy($ids);
            $message = 'Artikel terpilih berhasil dihapus!';
        } elseif ($request->bulk_action === 'unarchive') {
            $articles->update(['status' => 'draft']);
            $message = 'Artikel terpilih berhasil dikembalikan ke Draft!';
        } else {
            $articles->update(['status' => 'archived']);
            $message = 'Artikel terpilih berhasil diarsipkan!';
        }

        return back()->with('success', $message);
    }

    public function downloadPdf($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $path = storage_path("app/public/articles/{$article->id}.pdf");
        if (!file_exists($path)) {
            return back()->with('error', 'Dokumen PDF belum tersedia untuk artikel ini.');
        }
        return response()->download($path, \Str::slug($article->title) . '.pdf');
    }
}