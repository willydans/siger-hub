<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Opd;
use App\Models\ActivityLog;
use App\Models\Notification; // ✅ Tambahkan model Notification
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    /**
     * Menampilkan daftar artikel dengan filter dan sorting.
     * Jika status = 'deleted', tampilkan artikel yang sudah di-soft delete.
     */
    public function index(Request $request, $status = null)
    {
        $query = Article::with('user')->orderBy('created_at', 'desc');

        if ($status === 'deleted') {
            $articles = $query->onlyTrashed()->paginate(10)->appends($request->except('page'));
            return view('admin-delete', compact('articles'));
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Filter
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

        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $opds = Opd::orderBy('name')->get();

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
            if ($status === 'pending') {
                $viewFile = 'admin-pending-approval';
            }
        }

        return view($viewFile, compact('articles', 'users', 'categories', 'opds', 'status', 'pageTitle', 'statusLabel'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->only(['title', 'category', 'status', 'visibility', 'version']);

        if ($request->has('status') && $request->status === 'published' && is_null($article->published_at)) {
            $data['published_at'] = now();
        }

        $article->update($data);
        return redirect()->route('admin.all-articles')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $title = $article->title;
        $article->delete();

        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => "Artikel '{$title}' dipindahkan ke Recycle Bin.",
        ]);

        // (Opsional) Kirim notifikasi ke staff bahwa artikel dihapus sementara
        // Notification::create([...]);

        return redirect()->back()->with('success', "Artikel '{$title}' berhasil dipindahkan ke Recycle Bin.");
    }

    /**
     * Menyetujui artikel (ubah status dari pending menjadi published).
     * ✅ Kirim notifikasi ke staff.
     */
    public function approve($id)
    {
        $article = Article::findOrFail($id);
        $data = [
            'status' => 'published',
            'reviewed_by_user_id' => auth()->id(),
        ];
        if (is_null($article->published_at)) {
            $data['published_at'] = now();
        }
        $article->update($data);

        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => 'Artikel disetujui oleh admin',
            'properties'   => json_encode(['old_status' => 'pending', 'new_status' => 'published']),
        ]);

        // ✨ Notifikasi ke Staff
        Notification::create([
            'user_id'    => $article->user_id,
            'article_id' => $article->id,
            'type'       => 'Approval',
            'title'      => '✅ Artikel Disetujui',
            'message'    => "Artikel '{$article->title}' telah disetujui dan dipublikasikan oleh Admin.",
            'url'        => route('staff.articles'),
            'is_read'    => false,
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil disetujui dan dipublikasikan.');
    }

    /**
     * Menolak artikel (ubah status menjadi revision).
     * ✅ Kirim notifikasi ke staff.
     */
    public function reject($id)
    {
        $article = Article::findOrFail($id);
        $article->update([
            'status' => 'revision',
            'reviewed_by_user_id' => auth()->id(),
        ]);

        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => 'Artikel ditolak oleh admin',
            'properties'   => json_encode(['old_status' => 'pending', 'new_status' => 'revision']),
        ]);

        // ✨ Notifikasi ke Staff
        Notification::create([
            'user_id'    => $article->user_id,
            'article_id' => $article->id,
            'type'       => 'Revision',
            'title'      => '🔄 Artikel Ditolak & Perlu Revisi',
            'message'    => "Artikel '{$article->title}' ditolak dan diminta revisi oleh Admin. Silakan perbaiki dan kirim ulang.",
            'url'        => route('staff.revision'),
            'is_read'    => false,
        ]);

        return redirect()->back()->with('success', 'Artikel ditolak dan dikembalikan ke revisi.');
    }

    public function archive($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['status' => 'archived']);

        // ✨ Notifikasi ke Staff
        Notification::create([
            'user_id'    => $article->user_id,
            'article_id' => $article->id,
            'type'       => 'System',
            'title'      => '📦 Artikel Diarsipkan',
            'message'    => "Artikel '{$article->title}' telah diarsipkan oleh Admin.",
            'url'        => route('staff.articles'),
            'is_read'    => false,
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil diarsipkan.');
    }

    /**
     * Restore: Memulihkan artikel dari Recycle Bin dan mengubah status menjadi draft.
     * ✅ Kirim notifikasi ke staff.
     */
    public function restore($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $title = $article->title;
        $article->restore();
        $article->status = 'draft';
        $article->save();

        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => "Artikel '{$title}' dipulihkan dari Recycle Bin.",
        ]);

        // ✨ Notifikasi ke Staff
        Notification::create([
            'user_id'    => $article->user_id,
            'article_id' => $article->id,
            'type'       => 'System',
            'title'      => '♻️ Artikel Dipulihkan',
            'message'    => "Artikel '{$title}' telah dikembalikan ke Draft oleh Admin.",
            'url'        => route('staff.draft'),
            'is_read'    => false,
        ]);

        return redirect()->route('admin.delete')->with('success', "Artikel '{$title}' berhasil dipulihkan ke Draft.");
    }

    public function forceDelete($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $title = $article->title;

        if ($article->thumbnail) {
            \Storage::disk('public')->delete($article->thumbnail);
        }

        $article->forceDelete();

        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => "Artikel '{$title}' dihapus permanen.",
        ]);

        return redirect()->route('admin.delete')->with('success', "Artikel '{$title}' berhasil dihapus permanen.");
    }

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

    public function show($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }

    public function history($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $history = ActivityLog::where('subject_id', $id)
                    ->where('subject_type', 'App\Models\Article')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.articles.history', compact('article', 'history'));
    }

    public function getArticleJson($id)
    {
        $article = Article::with('user')->findOrFail($id);
        return response()->json($article);
    }

    /**
     * Mengirim permintaan revisi (menyimpan seluruh detail form revisi).
     * ✅ Kirim notifikasi ke staff.
     */
    public function revision(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $revisionData = $request->only([
            'title_revision',
            'content_revision',
            'attachments_revision',
            'category_revision',
            'tags_revision',
            'thumbnail_revision',
            'others_revision',
            'priority',
            'deadline',
            'note',
        ]);

        $article->update([
            'status'              => 'revision',
            'reviewed_by_user_id' => auth()->id(),
            'revision_notes'      => json_encode($revisionData),
        ]);

        ActivityLog::create([
            'subject_id'   => $article->id,
            'subject_type' => 'App\Models\Article',
            'causer_id'    => auth()->id(),
            'description'  => 'Admin meminta revisi: ' . ($revisionData['note'] ?: '-'),
            'properties'   => json_encode($revisionData),
        ]);

        // ✨ Notifikasi ke Staff
        Notification::create([
            'user_id'    => $article->user_id,
            'article_id' => $article->id,
            'type'       => 'Revision',
            'title'      => '📝 Admin Meminta Revisi',
            'message'    => "Admin meminta revisi untuk artikel '{$article->title}'. Silakan cek detail revisi di halaman Revision.",
            'url'        => route('staff.revision'),
            'is_read'    => false,
        ]);

        return response()->json(['message' => 'Permintaan revisi berhasil dikirim ke penulis.']);
    }
}