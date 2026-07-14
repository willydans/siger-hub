<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserActivity;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Opd;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class StaffEditorController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $opds = Opd::all();
        $tags = Tag::all();

        return view('staff-editor', compact('categories', 'subcategories', 'opds', 'tags'));
    }

    public function edit($id)
    {
        $article = Article::where('user_id', auth()->id())->find($id);

        if (!$article) {
            return redirect()->route('staff.articles')->with('error', 'Artikel tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $categories = Category::all();
        $subcategories = Subcategory::all();
        $opds = Opd::all();
        $tags = Tag::all();

        return view('staff-editor', compact('article', 'categories', 'subcategories', 'opds', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'content'     => 'required|string|min:300',
            'thumbnail'   => 'required|file|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $this->generateUniqueSlug($request->title),
            'content' => $request->content,
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'opd_unit' => $request->opd_unit,
            'tags' => $request->tags ? explode(',', $request->tags) : null,
            'visibility' => $request->visibility ?? 'public',
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'estimated_read_time' => $request->estimated_read_time,
            'language' => $request->language ?? 'id',
            'version' => $request->version,
            'doc_code' => $request->doc_code,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'status' => 'draft',
            'progress' => $request->progress ?? 0,
            'relations' => $request->relations ? array_filter($request->relations) : null,
        ];

        $article = Article::create($data);
        $this->handleThumbnail($request, $article);

        if ($request->has('uploaded_attachments') && is_array($request->uploaded_attachments) && count($request->uploaded_attachments) > 0) {
            $article->update(['attachments' => $request->uploaded_attachments]);
        } else {
            $article->update(['attachments' => null]);
        }

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Upload Artikel',
            'description'=> 'Mengunggah artikel baru: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('staff.editor.edit', $article->id)->with('success', 'Draft artikel berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'content'     => 'required|string|min:300',
            'thumbnail'   => 'file|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => $this->generateUniqueSlugForUpdate($request->title, $id),
            'content' => $request->content,
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'opd_unit' => $request->opd_unit,
            'tags' => $request->tags ? explode(',', $request->tags) : null,
            'visibility' => $request->visibility ?? 'public',
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'estimated_read_time' => $request->estimated_read_time,
            'language' => $request->language ?? 'id',
            'version' => $request->version,
            'doc_code' => $request->doc_code,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'progress' => $request->progress ?? 0,
            'relations' => $request->relations ? array_filter($request->relations) : null,
        ];

        $article->update($data);
        $this->handleThumbnail($request, $article, true);

        if ($request->has('uploaded_attachments') && is_array($request->uploaded_attachments) && count($request->uploaded_attachments) > 0) {
            $article->update(['attachments' => $request->uploaded_attachments]);
        } else {
            $article->update(['attachments' => null]);
        }

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Edit Artikel',
            'description'=> 'Mengedit artikel: ' . $article->title,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil diperbarui!');
    }

    public function submitApproval($id)
    {
        $article = Article::where('user_id', auth()->id())->where('status', 'draft')->findOrFail($id);
        $article->update(['status' => 'pending']);

        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            if (class_exists('\App\Notifications\ArticleSubmittedNotification')) {
                $admin->notify(new \App\Notifications\ArticleSubmittedNotification($article, auth()->user()));
            }
        }

        UserActivity::create([
            'user_id'    => auth()->id(),
            'article_id' => $article->id,
            'type'       => 'Submit Approval',
            'description'=> 'Mengajukan artikel ke admin untuk disetujui: ' . $article->title,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('staff.dashboard')->with('success', 'Artikel berhasil dikirim ke Admin untuk review!');
    }

    // ✅ FIX: field yang dikirim CKEditor namanya "upload", bukan "file".
    // Sebelumnya validate() mengecek "file" yang tidak pernah ada di request ini,
    // jadi validasi selalu gagal duluan sebelum sempat pakai fallback ke "upload".
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|file|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $file = $request->file('upload');

        try {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');

            return response()->json([
                'url' => '/storage/' . $path
            ]);

        } catch (\Exception $e) {
            \Log::error('Upload Gambar CKEditor Gagal: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengupload: ' . $e->getMessage()], 500);
        }
    }

    public function uploadAttachment(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('attachments', 'public');
                return response()->json(['success' => true, 'path' => $path]);
            }
            return response()->json(['error' => 'Tidak ada file yang diunggah.'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * ✅ PERBAIKAN AI ASSISTANT MENGGUNAKAN GOOGLE GEMINI API
     */
    public function aiAssistant(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'content' => 'required|string'
        ]);

        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            \Log::error('AI Assistant Gagal: GEMINI_API_KEY kosong');
            return response()->json(['result' => 'Error: GEMINI_API_KEY belum diatur di file .env'], 400);
        }

        // Model yang digunakan
        $model = 'gemini-2.5-flash';
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $prompt = "Tugas: {$request->action}\n\nKonten Artikel:\n{$request->content}";

        try {
            \Log::info('AI Request ke Google Gemini dimulai. Action: ' . $request->action);

            $response = Http::timeout(30)
                ->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 2048,
                    ]
                ]);

            if (!$response->successful()) {
                \Log::error('Google Gemini Response Error: ' . $response->body());
                $status = $response->status();
                $body = $response->body();
                
                $errorMessage = match ($status) {
                    400 => 'Format request ke Google Gemini salah.',
                    403 => 'API Key Google Gemini tidak valid atau kuota habis.',
                    429 => 'Terlalu banyak permintaan. Tunggu beberapa saat.',
                    default => "Google Gemini Error (Status {$status}): " . $body
                };
                
                return response()->json(['result' => $errorMessage], $status);
            }

            $data = $response->json();
            
            // Ambil teks hasil AI dari response JSON Google Gemini
            $result = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'AI tidak memberikan respons.';
            
            \Log::info('AI Request sukses.');
            return response()->json(['result' => trim($result)]);

        } catch (\Exception $e) {
            \Log::error('AI Assistant Exception: ' . $e->getMessage());
            return response()->json([
                'result' => 'Kesalahan Koneksi ke Google Gemini: ' . $e->getMessage()
            ], 500);
        }
    }

    private function handleThumbnail(Request $request, Article $article, $isUpdate = false)
    {
        if (!$request->hasFile('thumbnail')) return;

        $file = $request->file('thumbnail');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('thumbnails', $filename, 'public');

        if ($isUpdate && $article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->update(['thumbnail' => $path]);
    }

    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        if (strlen($slug) > 100) $slug = substr($slug, 0, 100);
        $original = $slug;
        $count = 1;
        $query = Article::where('slug', $slug);
        if ($excludeId) $query->where('id', '!=', $excludeId);
        while ($query->exists()) {
            $newSlug = $original . '-' . $count;
            if (strlen($newSlug) > 100) $newSlug = substr($original, 0, 100 - strlen($count) - 1) . '-' . $count;
            $slug = $newSlug;
            $count++;
            $query = Article::where('slug', $slug);
            if ($excludeId) $query->where('id', '!=', $excludeId);
        }
        return $slug;
    }

    private function generateUniqueSlugForUpdate($title, $id)
    {
        return $this->generateUniqueSlug($title, $id);
    }
}