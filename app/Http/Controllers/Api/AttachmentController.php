<?php

// FILE: app/Http/Controllers/Api/AttachmentController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attachment\UploadAttachmentRequest;
use App\Models\Article;
use App\Models\Attachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    use ApiResponse;

    // Mapping MIME type → file_type enum di tabel attachments
    private function resolveFileType(string $mime): string
    {
        return match (true) {
            in_array($mime, ['image/jpeg', 'image/png', 'image/webp']) => 'image',
            $mime === 'application/pdf'                                  => 'pdf',
            in_array($mime, [
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            ])                                                           => 'powerpoint',
            default                                                      => 'other',
        };
    }

    // ── POST /api/v1/staff/articles/{id}/attachments ───────────────
    // Upload attachment ke artikel milik staff yang login
    public function upload(UploadAttachmentRequest $request, int $articleId): JsonResponse
    {
        $user    = $request->user();
        $article = Article::where('id', $articleId)
            ->where('user_id', $user->id)
            ->first();

        // Admin bisa upload ke artikel siapapun
        if (!$article && $user->isAdmin()) {
            $article = Article::find($articleId);
        }

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan atau bukan milik Anda.');
        }

        // Hanya artikel berstatus draft atau revision yang bisa ditambah attachment
        if (!in_array($article->status, ['draft', 'revision', 'published'])) {
            return $this->forbidden('Tidak bisa menambah attachment ke artikel dengan status "' . $article->status . '".');
        }

        $file         = $request->file('file');
        $mime         = $file->getMimeType();
        $fileType     = $this->resolveFileType($mime);
        $originalName = $file->getClientOriginalName();

        // Generate nama file unik dengan UUID supaya tidak bentrok
        $extension = $file->getClientOriginalExtension();
        $fileName  = Str::uuid() . '.' . $extension;

        // Simpan ke storage/app/public/attachments/{article_id}/
        $folder   = 'attachments/' . $articleId;
        $filePath = $file->storeAs($folder, $fileName, 'public');

        $attachment = Attachment::create([
            'article_id'    => $article->id,
            'uploaded_by'   => $user->id,
            'original_name' => $originalName,
            'file_name'     => $fileName,
            'file_path'     => $filePath,
            'disk'          => 'public',
            'mime_type'     => $mime,
            'file_size'     => $file->getSize(),
            'file_type'     => $fileType,
            'download_count'=> 0,
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($article)
            ->withProperties(['attachment_id' => $attachment->id, 'file' => $originalName])
            ->log('upload_attachment');

        return $this->created([
            'id'            => $attachment->id,
            'original_name' => $attachment->original_name,
            'file_type'     => $attachment->file_type,
            'file_size'     => $attachment->file_size_human,
            'mime_type'     => $attachment->mime_type,
            'download_url'  => route('attachments.download', $attachment->id),
        ], 'File berhasil diupload.');
    }

    // ── GET /api/v1/attachments/{id}/download ──────────────────────
    // Download file — cek hak akses berdasarkan visibility artikel
    public function download(Request $request, int $id): mixed
    {
        $attachment = Attachment::with('article')->find($id);

        if (!$attachment) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan.',
            ], 404);
        }

        $article = $attachment->article;
        $user    = $request->user(); // null kalau guest

        // Cek hak akses berdasarkan visibility artikel
        if ($article->visibility === 'restricted' && !$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk mengunduh file ini.',
            ], 401);
        }

        if ($article->visibility === 'private') {
            if (!$user || ($user->id !== $article->user_id && !$user->isAdmin())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengunduh file ini.',
                ], 403);
            }
        }

        // Cek file fisik ada di storage
        if (!Storage::disk('public')->exists($attachment->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan di server.',
            ], 404);
        }

        // Increment download counter
        $attachment->incrementDownload();

        // Stream file sebagai download
        return Storage::disk('public')->download(
            $attachment->file_path,
            $attachment->original_name
        );
    }

    // ── GET /api/v1/attachments/{id}/preview ──────────────────────
    // Preview file di browser (untuk gambar & PDF — inline, bukan download)
    public function preview(Request $request, int $id): mixed
    {
        $attachment = Attachment::with('article')->find($id);

        if (!$attachment) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan.',
            ], 404);
        }

        $article = $attachment->article;
        $user    = $request->user();

        // Cek hak akses (sama dengan download)
        if ($article->visibility === 'restricted' && !$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk melihat file ini.',
            ], 401);
        }

        if ($article->visibility === 'private') {
            if (!$user || ($user->id !== $article->user_id && !$user->isAdmin())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke file ini.',
                ], 403);
            }
        }

        if (!Storage::disk('public')->exists($attachment->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan di server.',
            ], 404);
        }

        // Hanya image dan PDF yang bisa di-preview inline
        $previewable = ['image', 'pdf'];
        if (!in_array($attachment->file_type, $previewable)) {
            return response()->json([
                'success' => false,
                'message' => 'Tipe file ini tidak bisa di-preview, gunakan endpoint download.',
            ], 422);
        }

        return Storage::disk('public')->response(
            $attachment->file_path,
            $attachment->original_name,
            ['Content-Disposition' => 'inline']
        );
    }

    // ── DELETE /api/v1/staff/articles/{articleId}/attachments/{id} ─
    // Hapus attachment — staff hapus milik sendiri, admin hapus semua
    public function destroy(Request $request, int $articleId, int $id): JsonResponse
    {
        $user       = $request->user();
        $attachment = Attachment::where('id', $id)
            ->where('article_id', $articleId)
            ->first();

        if (!$attachment) {
            return $this->notFound('Attachment tidak ditemukan.');
        }

        // Cek ownership — staff hanya bisa hapus attachment di artikel miliknya
        $article = $attachment->article;
        if ($article->user_id !== $user->id && !$user->isAdmin()) {
            return $this->forbidden('Anda tidak memiliki izin menghapus file ini.');
        }

        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        activity()
            ->causedBy($user)
            ->withProperties(['file' => $attachment->original_name])
            ->log('delete_attachment');

        return $this->success(null, 'File berhasil dihapus.');
    }

    // ── GET /api/v1/articles/{slug}/attachments ────────────────────
    // List semua attachment untuk artikel (public endpoint)
    public function listByArticle(Request $request, string $slug): JsonResponse
    {
        $article = Article::published()->where('slug', $slug)->first();

        if (!$article) {
            return $this->notFound('Artikel tidak ditemukan.');
        }

        $user = $request->user();

        // Cek visibility
        if ($article->visibility === 'restricted' && !$user) {
            return $this->forbidden('Anda harus login untuk melihat lampiran artikel ini.');
        }

        if ($article->visibility === 'private') {
            if (!$user || ($user->id !== $article->user_id && !$user->isAdmin())) {
                return $this->forbidden('Anda tidak memiliki akses ke artikel ini.');
            }
        }

        $attachments = $article->attachments()
            ->orderBy('file_type')
            ->orderBy('created_at')
            ->get()
            ->map(fn ($att) => [
                'id'             => $att->id,
                'original_name'  => $att->original_name,
                'file_type'      => $att->file_type,
                'mime_type'      => $att->mime_type,
                'file_size'      => $att->file_size_human,
                'download_count' => $att->download_count,
                'download_url'   => route('attachments.download', $att->id),
                'preview_url'    => in_array($att->file_type, ['image', 'pdf'])
                    ? route('attachments.preview', $att->id)
                    : null,
                'uploaded_at'    => $att->created_at->toDateTimeString(),
            ]);

        return $this->success($attachments);
    }
}