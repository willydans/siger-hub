<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserActivity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StaffArticleController extends Controller
{
    /**
     * Menampilkan list artikel dengan filter, search, sorting & pagination
     */
    public function index(Request $request)
    {
        $userId = auth()->id();

        $allowedSortColumns = ['created_at', 'rating_avg', 'views', 'title'];
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
                return $query->where('tags', 'like', "%{$request->tag}%");
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

    // --- CRUD: Tampilan Form (Create, Edit) ---

    public function create()
    {
        return view('staff-articles-create');
    }

    public function edit($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        return view('staff-articles-edit', compact('article'));
    }

    // --- CRUD: Aksi Simpan (Store, Update) ---

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'category'   => 'required|string|max:100',
            'visibility' => ['required', Rule::in(['public', 'internal', 'restricted', 'private'])],
            'tags'       => 'nullable|string',
        ]);

        $article = Article::create([
            'user_id'    => auth()->id(),
            'title'      => $request->title,
            'slug'       => Str::slug($request->title . ' ' . uniqid()),
            'content'    => $request->content,
            'category'   => $request->category,
            'visibility' => $request->visibility,
            'tags'       => $request->tags,
            'status'     => 'draft',
        ]);

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Tambah Artikel',
            'description'=> 'Menambahkan artikel baru: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('staff.articles')->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Update lengkap dengan logika pengisian published_at otomatis.
     */
    public function update(Request $request, $id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'category'   => 'required|string|max:100',
            'visibility' => ['required', Rule::in(['public', 'internal', 'restricted', 'private'])],
            'tags'       => 'nullable|string',
            'status'     => 'nullable|in:draft,published,review,revision,archived',
        ]);

        $dataToUpdate = [
            'title'      => $request->title,
            'content'    => $request->content,
            'category'   => $request->category,
            'visibility' => $request->visibility,
            'tags'       => $request->tags,
        ];

        if ($request->has('status')) {
            $dataToUpdate['status'] = $request->status;
            if ($request->status === 'published' && is_null($article->published_at)) {
                $dataToUpdate['published_at'] = now();
            }
        }

        $article->update($dataToUpdate);

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Update Artikel',
            'description'=> 'Memperbarui artikel: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('staff.articles')->with('success', 'Artikel berhasil diperbarui!');
    }

    // --- Method Tampilan (Show, Preview, History) ---

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

        $revisions = UserActivity::where('article_id', $article->id)
            ->whereIn('type', ['Tambah Artikel', 'Update Artikel', 'Edit Cepat Artikel', 'Publikasi Artikel', 'Duplikasi Artikel'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff-articles-history', compact('article', 'revisions'));
    }

    // --- Method Aksi Lainnya (Quick Update, Duplicate, Archive, dll) ---

    /**
     * Quick Update dengan logika pengisian published_at otomatis.
     */
    public function quickUpdate(Request $request, $id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|string|max:100',
            'visibility' => ['required', Rule::in(['public', 'internal', 'restricted', 'private'])],
            'status'     => 'nullable|in:draft,published,review,revision,archived',
        ]);

        $dataToUpdate = [
            'title'      => $request->title,
            'category'   => $request->category,
            'visibility' => $request->visibility,
        ];

        if ($request->has('status')) {
            $dataToUpdate['status'] = $request->status;
            if ($request->status === 'published' && is_null($article->published_at)) {
                $dataToUpdate['published_at'] = now();
            }
        }

        $article->update($dataToUpdate);

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

    /**
     * ✨ REVISI PENTING: Duplikasi sekarang mereset rating_avg dan rating_count menjadi 0!
     */
    public function duplicate($id)
    {
        $original = Article::where('user_id', auth()->id())->findOrFail($id);

        try {
            $newArticle = DB::transaction(function () use ($original) {
                $newArticle = $original->replicate();
                $newArticle->title = $original->title . ' (Copy)';
                $newArticle->status = 'draft';
                $newArticle->views = 0;
                $newArticle->rating_avg = 0; // ✅ Reset rata-rata rating
                $newArticle->rating_count = 0; // ✅ Reset jumlah rating
                $newArticle->slug = Str::slug($original->title . ' ' . uniqid());
                $newArticle->created_at = now();
                $newArticle->updated_at = now();
                $newArticle->save();

                UserActivity::create([
                    'user_id'    => auth()->id(),
                    'article_id' => $newArticle->id,
                    'type'       => 'Duplikasi Artikel',
                    'description'=> 'Menduplikasi artikel dari: ' . $original->title,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);

                return $newArticle;
            });
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menduplikasi artikel. Silakan coba lagi.');
        }

        return back()->with('success', 'Berhasil menduplikasi artikel menjadi "' . $newArticle->title . '"!');
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
        $title = $article->title;

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

    /**
     * Download PDF artikel.
     */
    public function downloadPdf($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        try {
            $pdf = Pdf::loadView('pdf.article', compact('article'));
            return $pdf->download('artikel-' . Str::slug($article->title) . '.pdf');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghasilkan file PDF. Pastikan library DomPDF sudah terinstall.');
        }
    }
}