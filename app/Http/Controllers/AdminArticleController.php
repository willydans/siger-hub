<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Opd;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
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

        // Paginasi diubah ke 15 menyesuaikan dengan format teman
        $articles = $query->paginate(15)->appends($request->except('page'));

        // Data untuk dropdown filter
        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $opds = Opd::orderBy('name')->get();

        // Penyesuaian nama view agar cocok dengan milik teman ('admin-allarticles')
        $pageTitle = 'All Articles';
        $statusLabel = 'Semua artikel';
        $viewFile = 'admin-allarticles'; 

        if ($status) {
            $labelMap = [
                'pending'   => 'Pending Approval',
                'draft'     => 'Draft',
                'revision'  => 'Revision',
                'published' => 'Published',
                'archive'   => 'Archived', 
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

    // ========== METHOD TAMBAHAN DARI TEMAN ==========

    /**
     * Halaman Khusus Published (Opsional jika route dipisah)
     */
    public function published()
    {
        $articles = Article::with('user')->where('status', 'published')->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();
        $opds = Opd::all();
        $users = User::all();
        
        return view('admin-published', compact('articles', 'categories', 'opds', 'users'));
    }

    /**
     * Halaman Khusus Archive (Opsional jika route dipisah)
     */
    public function archived()
    {
        $articles = Article::with('user')->where('status', 'archived')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin-archive', compact('articles'));
    }

    /**
     * Halaman Deleted (Recycle Bin) - Tambahan dari teman
     */
    public function deleted()
    {
        $articles = Article::onlyTrashed()->with('user')->orderBy('deleted_at', 'desc')->paginate(15);
        return view('admin-delete', compact('articles'));
    }

    /**
     * Halaman Draft — menampilkan artikel milik semua user berstatus draft.
     */
    public function draft()
    {
        $articles = Article::with('user')
            ->where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin-draft', compact('articles'));
    }

    /**
     * Menghapus artikel secara permanen (Force Delete) - Tambahan dari teman
     */
    public function forceDelete($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $article->forceDelete();
        return back()->with('success', 'Artikel dihapus permanen.');
    }

    // ========== LOGIKA CRUD & ACTIVITY LOG (Milikmu) ==========
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $opds = Opd::orderBy('name')->get();
        
        // Catatan: Jika aplikasimu menggunakan Subkategori, uncomment baris di bawah:
        $subcategories = \App\Models\Subcategory::all() ?? []; 
        
        return view('admin-editor', compact('categories', 'subcategories', 'opds'));
    }
    public function uploadAttachment(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan ke storage/app/public/attachments
            $path = $file->storeAs('attachments', $filename, 'public');
            
            return response()->json([
                'success' => true,
                'path' => $path
            ]);
        }

        return response()->json(['success' => false, 'error' => 'Tidak ada file yang diunggah'], 400);
    }
    public function autoFillMetadata(Request $request)
    {
        $content = $request->input('content');
        $apiKey = env('GEMINI_API_KEY');
        
        if (empty($apiKey)) {
            return response()->json(['success' => false, 'error' => 'API Key Gemini kosong. Jalankan php artisan config:clear'], 500);
        }
        
        $prompt = "Buatkan metadata SEO dari artikel berikut. Berikan response HANYA dalam format JSON murni tanpa awalan/akhiran markdown dengan key: category (string), subcategory (string), opd_unit (string), tags (array of string), meta_keywords (string), meta_description (string), estimated_read_time (integer menit). Artikel: \n\n" . $content;
        
        try {
            // withoutVerifying() digunakan agar localhost tidak diblokir oleh isu SSL
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $jsonString = $response->json('candidates.0.content.parts.0.text');
                // Bersihkan format markdown bawaan Gemini jika ada
                $jsonString = trim(str_replace(['```json', '```'], '', $jsonString));
                
                return response()->json([
                    'success' => true,
                    'data' => json_decode($jsonString, true)
                ]);
            }

            // Jika gagal, beritahu alasan spesifik dari Google
            return response()->json(['success' => false, 'error' => 'Google API Error: ' . $response->body()], 500);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Handle AI Assistant Actions (Ringkas, EYD, dll)
     */
    public function aiAssistant(Request $request)
    {
        $action = $request->input('action');
        $content = $request->input('content');
        $apiKey = env('GEMINI_API_KEY');
        
        if (empty($apiKey)) {
            return response()->json(['error' => 'API Key Gemini kosong. Jalankan php artisan config:clear'], 500);
        }
        
        $prompt = "Tolong lakukan aksi '{$action}' pada teks artikel berikut. Berikan langsung hasilnya saja tanpa teks pengantar atau basa-basi tambahan: \n\n" . $content;
        
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $resultText = $response->json('candidates.0.content.parts.0.text');
                return response()->json([
                    'result' => trim($resultText)
                ]);
            }

            return response()->json(['error' => 'Google API Error: ' . $response->body()], 500);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $subcategories = \App\Models\Subcategory::all() ?? [];
        $opds = Opd::orderBy('name')->get();

        return view('admin-editor', compact('article', 'categories', 'subcategories', 'opds'));
    }
    public function submit($id)
    {
    $article = Article::findOrFail($id);
    
    // Logika untuk mengubah status dari draft menjadi pending/submitted
    $article->status = 'published'; // atau status lain yang Anda gunakan
    $article->save();

    return redirect()->back()->with('success', 'Artikel berhasil disubmit untuk approval!');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'content'     => 'required|string|min:300',
            'thumbnail'   => 'required|file|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // 1. Buat Slug unik terlebih dahulu SEBELUM menyusun array $data
        $originalSlug = \Illuminate\Support\Str::slug($request->title);
        $slug = $originalSlug;
        $count = 1;

        // ✅ PERBAIKAN: Tambahkan withTrashed() agar mengecek artikel yang ada di Recycle Bin juga
        while (\App\Models\Article::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        // 1. Resolve Category ID
        $categoryId = $request->category;
        if (!is_numeric($categoryId)) {
            $category = \App\Models\Category::firstOrCreate(
                ['name' => $categoryId],
                ['slug' => \Illuminate\Support\Str::slug($categoryId)] // Tambahkan slug
            );
            $categoryId = $category->id;
        }

        // 2. Resolve Subcategory ID
        $subcategoryId = $request->subcategory;
        if (!empty($subcategoryId) && !is_numeric($subcategoryId)) {
            $subcategory = \App\Models\Subcategory::firstOrCreate(
                ['name' => $subcategoryId, 'category_id' => $categoryId],
                ['slug' => \Illuminate\Support\Str::slug($subcategoryId)] // Tambahkan slug
            );
            $subcategoryId = $subcategory->id;
        }

        // 3. Resolve OPD ID (Solusi error 'slug' Presiden Republik Indonesia)
        $opdId = $request->opd_unit;
        if (!empty($opdId) && !is_numeric($opdId)) {
            $opd = \App\Models\Opd::firstOrCreate(
                ['name' => $opdId],
                ['slug' => \Illuminate\Support\Str::slug($opdId)] // Tambahkan slug
            );
            $opdId = $opd->id;
        }

        // 2. Susun array data
        $data = [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $slug, 
            'content' => $request->content,
            
            // ✅ PERBAIKAN DI SINI: Gunakan variabel yang sudah di-resolve, bukan dari $request lagi
            'category_id' => $categoryId,
            'subcategory_id' => $subcategoryId,
            'opd_id' => $opdId,
            
            'tags_json' => $request->tags ? json_encode(explode(',', $request->tags)) : null,
            'visibility' => $request->visibility ?? 'public',
            'keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'estimated_read_time' => $request->estimated_read_time,
            'language' => $request->language ?? 'id',
            'version' => $request->version ?: '1.0',
            'doc_code' => $request->doc_code,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'status' => 'draft',
            'progress' => $request->progress ?? 0,
            'relations' => $request->relations ? array_filter($request->relations) : null,
        ];

        // 3. Simpan ke database 
        $article = Article::create($data);
        $this->handleThumbnail($request, $article);

        if ($request->has('uploaded_attachments') && is_array($request->uploaded_attachments) && count($request->uploaded_attachments) > 0) {
            $article->update(['attachments' => $request->uploaded_attachments]);
        } else {
            $article->update(['attachments' => null]);
        }

        // Memanggil model UserActivity langsung agar tidak perlu merubah use/import di atas
        \App\Models\UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Upload Artikel',
            'description'=> 'Admin mengunggah artikel baru: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Berbeda dengan staff, Admin dikembalikan ke halaman tabel All Articles
        return redirect()->route('admin.all-articles')->with('success', 'Draft artikel berhasil disimpan!');
    }

    /**
     * Helper: Membuat slug (URL) unik secara otomatis
     */
    protected function generateUniqueSlug($title)
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Helper: Mengunggah dan menyimpan file thumbnail
     */
    protected function handleThumbnail(Request $request, $article)
    {
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('thumbnails', $filename, 'public');
            
            $article->update(['thumbnail' => $path]);
        }
    }

    public function update(Request $request, $id)
{
    $article = Article::findOrFail($id);

    // Validasi dasar (sesuaikan dengan kebutuhan)
    $request->validate([
        'title'       => 'required|string|max:255',
        'category'    => 'required|string',
        'content'     => 'required|string|min:10', // Turunkan minimal karakter jika perlu
    ]);

    $data = [
        'title' => $request->title,
        // Update slug hanya jika judul berubah (opsional, jika ingin slug dinamis)
        'slug' => $article->title !== $request->title ? $this->generateUniqueSlug($request->title) : $article->slug,
        'content' => $request->content,
        'category_id' => $request->category,
        'subcategory_id' => $request->subcategory,
        'opd_id' => $request->opd_unit,
        'tags_json' => $request->tags ? json_encode(explode(',', $request->tags)) : null,
        'visibility' => $request->visibility ?? 'public',
        'keywords' => $request->meta_keywords,
        'meta_description' => $request->meta_description,
        'estimated_read_time' => $request->estimated_read_time,
        'language' => $request->language ?? 'id',
        'version' => $request->version ?: '1.0',
        'doc_code' => $request->doc_code,
        'valid_from' => $request->valid_from,
        'valid_until' => $request->valid_until,
        'relations' => $request->relations ? array_filter($request->relations) : null,
        // Status tidak perlu diubah di sini karena tombol Simpan Draft tidak mengubah status
    ];

    $article->update($data);
    
    // Tangani thumbnail baru jika ada yang diupload
    if ($request->hasFile('thumbnail')) {
        $this->handleThumbnail($request, $article);
    }

    return redirect()->route('admin.draft')->with('success', 'Draft berhasil disimpan dan diperbarui!');
}

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete(); 
        
        return redirect()->back()->with('success', 'Artikel berhasil dipindahkan ke Recycle Bin.');
    }

    public function approve($id)
    {
        $article = Article::findOrFail($id);
        
        $data = ['status' => 'published'];
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

        return redirect()->back()->with('success', 'Artikel berhasil disetujui dan dipublikasikan.');
    }

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

    public function archive($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['status' => 'archived']);
        return redirect()->back()->with('success', 'Artikel berhasil diarsipkan.');
    }

    public function restore($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $article->restore();
        
        // Mempertahankan keamanan milikmu agar artikel kembali ke draft
        $article->status = 'draft';
        $article->save();

        return redirect()->back()->with('success', 'Artikel berhasil dipulihkan ke Draft!');
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
        
        $history = \Spatie\Activitylog\Models\Activity::where('subject_id', $id)
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

    public function revision(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $note = $request->input('note', '');
        
        $article->update(['status' => 'revision']);
        
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