<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserActivity;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Opd;
use App\Models\Tag;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class StaffEditorController extends Controller
{
    /**
     * ✅ Menentukan apakah request ini datang dari area admin atau staff,
     * berdasarkan PREFIX URL yang sedang diakses — bukan dari relasi
     * $user->role yang bisa saja null/gagal dimuat. Ini aman karena
     * middleware 'role:admin' / 'role:staff' di routes/web.php SUDAH
     * memvalidasi role user sebelum request sampai ke controller ini;
     * jadi kalau request lolos sampai sini dengan prefix /admin/*,
     * user tersebut SUDAH PASTI admin.
     */
    private function isAdminContext(): bool
    {
        return request()->is('admin/*');
    }

    private function getViewPrefix(): string
    {
        return $this->isAdminContext() ? 'admin' : 'staff';
    }

    private function getRedirectRoute(): string
    {
        return $this->isAdminContext() ? 'admin.all-articles' : 'staff.articles';
    }

    private function getEditorEditRoute(): string
    {
        return $this->isAdminContext() ? 'admin.editor.edit' : 'staff.editor.edit';
    }

    public function index()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $opds = Opd::all();
        $tags = Tag::all();

        $view = $this->getViewPrefix() . '-editor';
        return view($view, compact('categories', 'subcategories', 'opds', 'tags'));
    }

    /**
     * ✅ Menampilkan editor untuk mengedit artikel yang sudah ada.
     * - Admin bisa membuka SEMUA artikel (tidak dibatasi user_id & status).
     * - Staff hanya bisa membuka artikel MILIKNYA sendiri dan hanya status 'draft'/'revision'.
     */
    public function edit($id)
    {
        $isAdmin = $this->isAdminContext();

        $article = Article::find($id);

        if (!$article) {
            Log::warning("Editor edit: artikel #{$id} tidak ditemukan di database.", [
                'user_id'  => auth()->id(),
                'is_admin' => $isAdmin,
            ]);
            return redirect()->route($this->getRedirectRoute())
                ->with('error', "Artikel #{$id} tidak ditemukan (mungkin sudah dihapus).");
        }

        // Staff: hanya bisa edit artikel milik sendiri
        if (!$isAdmin && (int) $article->user_id !== (int) auth()->id()) {
            Log::warning("Editor edit: staff mencoba edit artikel milik user lain.", [
                'article_id'      => $article->id,
                'article_user_id' => $article->user_id,
                'logged_in_user'  => auth()->id(),
            ]);
            return redirect()->route($this->getRedirectRoute())
                ->with('error', 'Artikel ini bukan milik Anda, sehingga tidak bisa diedit.');
        }

        // Staff: hanya status draft & revision yang boleh diedit
        if (!$isAdmin && !in_array($article->status, ['draft', 'revision'])) {
            Log::info("Editor edit: staff mencoba edit artikel status tidak diizinkan.", [
                'article_id' => $article->id,
                'status'     => $article->status,
                'user_id'    => auth()->id(),
            ]);
            return redirect()->route($this->getRedirectRoute())
                ->with('error', 'Artikel sedang dalam proses review Admin atau sudah dipublikasikan. Anda tidak dapat mengeditnya saat status ini.');
        }

        // ✅ Admin: bebas edit semua status (tidak ada pengecekan status)

        $categories = Category::all();
        $subcategories = Subcategory::all();
        $opds = Opd::all();
        $tags = Tag::all();

        $view = $this->getViewPrefix() . '-editor';
        return view($view, compact('article', 'categories', 'subcategories', 'opds', 'tags'));
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

        return redirect()->route($this->getEditorEditRoute(), $article->id)->with('success', 'Draft artikel berhasil disimpan!');
    }

    /**
     * ✅ Update artikel yang sudah ada.
     * - Admin bisa update artikel siapa saja (tidak dibatasi status).
     * - Staff hanya bisa update miliknya sendiri dan hanya status draft/revision.
     */
    public function update(Request $request, $id)
    {
        $isAdmin = $this->isAdminContext();

        $query = Article::query();
        if (!$isAdmin) {
            $query->where('user_id', auth()->id());
        }
        $article = $query->findOrFail($id);

        // Staff: hanya draft & revision yang boleh diupdate
        if (!$isAdmin && !in_array($article->status, ['draft', 'revision'])) {
            return redirect()->route($this->getRedirectRoute())
                ->with('error', 'Tidak dapat memperbarui artikel yang sudah dalam proses review Admin atau sudah dipublikasikan.');
        }

        // ✅ Admin: bebas update semua status

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

    /**
     * ✅ Kirim artikel ke admin untuk approval (status jadi 'pending').
     * Berlaku sama untuk staff maupun admin yang menulis draft sendiri.
     */
    public function submitApproval($id)
    {
        $isAdmin = $this->isAdminContext();

        $query = Article::query();
        if (!$isAdmin) {
            $query->where('user_id', auth()->id());
        }
        $article = $query->where('status', 'draft')->findOrFail($id);

        $article->update(['status' => 'pending']);

        $admins = User::whereHas('role', function ($q) {
            $q->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            if (class_exists(Notification::class)) {
                Notification::create([
                    'user_id'    => $admin->id,
                    'article_id' => $article->id,
                    'type'       => 'Approval',
                    'title'      => '📝 Draft Baru Dikirim untuk Review',
                    'message'    => auth()->user()->name . ' telah mengirimkan draft berjudul "' . $article->title . '" untuk diperiksa dan disetujui.',
                    'url'        => route('admin.pending-approval'),
                    'is_read'    => false,
                ]);
            } elseif (class_exists('\App\Notifications\ArticleSubmittedNotification')) {
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

        return redirect()->route($this->getRedirectRoute())
            ->with('success', 'Artikel berhasil dikirim ke Admin untuk review! Menunggu persetujuan.');
    }

    // ========== UPLOAD METHODS ==========

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
            Log::error('Upload Gambar CKEditor Gagal: ' . $e->getMessage());
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

    // ========== AI ASSISTANT & METADATA ==========

    public function aiAssistant(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'content' => 'required|string'
        ]);

        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            Log::error('AI Assistant Gagal: GEMINI_API_KEY kosong');
            return response()->json(['result' => 'Error: GEMINI_API_KEY belum diatur di file .env'], 400);
        }

        $model = 'gemini-2.5-flash';
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $actionInstructions = [
            'Ringkas Artikel'        => 'Buat ringkasan singkat (maksimal 4 kalimat) dari artikel di atas dalam bentuk paragraf biasa, tanpa basa-basi pembuka seperti "Berikut ringkasannya".',
            'Generate Keyword'       => 'Berikan HANYA daftar 5-8 kata kunci SEO yang relevan, dipisah koma, tanpa penjelasan tambahan, tanpa penomoran, tanpa tanda kutip.',
            'Buat FAQ'               => 'Buat 3-5 pertanyaan yang mungkin muncul dari pembaca beserta jawaban singkatnya. Format setiap poin: "Q: ...\\nA: ...".',
            'Perbaiki Tata Bahasa'   => 'Perbaiki ejaan dan tata bahasa (sesuai EYD) dari isi artikel di atas. Kembalikan HANYA versi teks yang sudah diperbaiki, tanpa penjelasan tambahan, tanpa tanda kutip pembuka/penutup.',
            'Generate Tag'          => 'Berikan HANYA 5-8 tag singkat (1-2 kata per tag) yang relevan dengan isi artikel, dipisah koma, huruf kecil semua, tanpa penjelasan tambahan.',
            'Buat Deskripsi SEO'    => 'Buat SATU meta description SEO maksimal 155 karakter yang menarik dan deskriptif. Kembalikan HANYA teks deskripsinya saja, tanpa tanda kutip, tanpa penjelasan tambahan.',
        ];
        $instruction = $actionInstructions[$request->action] ?? '';

        $prompt = "Tugas: {$request->action}\n{$instruction}\n\nKonten Artikel:\n{$request->content}";

        try {
            Log::info('AI Request ke Google Gemini dimulai. Action: ' . $request->action);

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
                        'temperature' => 0.6,
                        'maxOutputTokens' => 2048,
                        'thinkingConfig' => [
                            'thinkingBudget' => 0,
                        ],
                    ]
                ]);

            if (!$response->successful()) {
                Log::error('Google Gemini Response Error: ' . $response->body());
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

            $result = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'AI tidak memberikan respons.';

            Log::info('AI Request sukses.');
            return response()->json(['result' => trim($result), 'action' => $request->action]);

        } catch (\Exception $e) {
            Log::error('AI Assistant Exception: ' . $e->getMessage());
            return response()->json([
                'result' => 'Kesalahan Koneksi ke Google Gemini: ' . $e->getMessage()
            ], 500);
        }
    }

    public function autoFillMetadata(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:50',
            'title'   => 'nullable|string',
        ]);

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'GEMINI_API_KEY belum diatur di file .env'], 400);
        }

        $categories = Category::pluck('name')->filter()->values();
        $subcategories = Subcategory::pluck('name')->filter()->values();
        $opds = Opd::pluck('name')->filter()->values();

        $model = 'gemini-2.5-flash';
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $plainContent = trim(strip_tags($request->content));
        $plainContent = Str::limit($plainContent, 6000, '');

        $title = $request->title ?? '(tidak ada judul)';
        $categoryList = $categories->implode(', ') ?: '(belum ada kategori terdaftar)';
        $subcategoryList = $subcategories->implode(', ') ?: '(belum ada subkategori terdaftar)';
        $opdList = $opds->implode(', ') ?: '(belum ada OPD terdaftar)';

        $prompt = <<<PROMPT
Kamu adalah asisten yang membantu melengkapi metadata artikel untuk portal knowledge management pemerintah (SIGER-Hub, Pemerintah Provinsi Lampung).

Judul artikel: {$title}

Isi artikel (teks polos):
{$plainContent}

Daftar Kategori yang tersedia di sistem (pilih SALAH SATU yang paling sesuai, tulisannya HARUS persis sama dengan salah satu di daftar ini; kalau tidak ada yang cocok sama sekali, kembalikan string kosong ""):
{$categoryList}

Daftar Subkategori yang tersedia (pilih SALAH SATU yang paling relevan dari daftar ini, atau string kosong "" kalau tidak ada yang cocok):
{$subcategoryList}

Daftar OPD/Unit yang tersedia (pilih SALAH SATU yang paling relevan dari daftar ini, atau string kosong "" kalau tidak jelas):
{$opdList}

Analisa isi artikel di atas, lalu kembalikan HANYA JSON valid (tanpa markdown, tanpa backtick, tanpa penjelasan apa pun di luar JSON) dengan format PERSIS seperti ini:
{"category": "...", "subcategory": "...", "opd_unit": "...", "tags": ["tag1", "tag2", "tag3"], "meta_keywords": "keyword1, keyword2, keyword3", "meta_description": "deskripsi singkat maksimal 155 karakter", "estimated_read_time": 3}
PROMPT;

        try {
            $response = Http::timeout(45)->post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'temperature' => 0.4,
                    'maxOutputTokens' => 2048,
                    'responseMimeType' => 'application/json',
                    'thinkingConfig' => [
                        'thinkingBudget' => 0,
                    ],
                ],
            ]);

            if (!$response->successful()) {
                Log::error('Gemini Autofill Error: ' . $response->body());
                return response()->json(['error' => 'Gagal menghubungi AI (status ' . $response->status() . ')'], $response->status());
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            $finishReason = $data['candidates'][0]['finishReason'] ?? null;

            if (!$text) {
                Log::error('Gemini Autofill: tidak ada teks hasil. finishReason=' . $finishReason . ' | raw=' . json_encode($data));
                return response()->json(['error' => 'AI tidak memberikan hasil (finish reason: ' . ($finishReason ?? 'unknown') . ').'], 500);
            }

            $clean = trim(preg_replace('/```json|```/', '', $text));
            $parsed = json_decode($clean, true);

            if (json_last_error() !== JSON_ERROR_NONE && preg_match('/\{.*\}/s', $clean, $matches)) {
                $parsed = json_decode($matches[0], true);
            }

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($parsed)) {
                Log::error('Gagal parse JSON dari Gemini Autofill. Raw text: ' . $text);
                return response()->json(['error' => 'Gagal memproses hasil AI. Coba lagi.'], 500);
            }

            if (!empty($parsed['category']) && !$categories->contains($parsed['category'])) {
                $parsed['category'] = null;
            }
            if (!empty($parsed['subcategory']) && !$subcategories->contains($parsed['subcategory'])) {
                $parsed['subcategory'] = null;
            }
            if (!empty($parsed['opd_unit']) && !$opds->contains($parsed['opd_unit'])) {
                $parsed['opd_unit'] = null;
            }
            if (empty($parsed['tags']) || !is_array($parsed['tags'])) {
                $parsed['tags'] = [];
            }

            return response()->json(['success' => true, 'data' => $parsed]);

        } catch (\Exception $e) {
            Log::error('AI Autofill Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Kesalahan koneksi ke AI: ' . $e->getMessage()], 500);
        }
    }

    // ========== PRIVATE HELPERS ==========

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