<?php

// FILE: app/Http/Controllers/Api/TagController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    use ApiResponse;

    // ── GET /api/v1/tags ───────────────────────────────────────────
    // Public: list semua tag (untuk autocomplete/filter di frontend)
    public function index(Request $request): JsonResponse
    {
        $query = Tag::withCount('articles')->orderBy('name');

        // Search tag by name (untuk autocomplete)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tags = $query->get()->map(fn ($tag) => [
            'id'            => $tag->id,
            'name'          => $tag->name,
            'slug'          => $tag->slug,
            'article_count' => $tag->articles_count,
        ]);

        return $this->success($tags);
    }

    // ── POST /api/v1/admin/tags ────────────────────────────────────
    // Admin: buat tag baru secara manual
    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        activity()->causedBy($request->user())->performedOn($tag)->log('create_tag');

        return $this->created([
            'id'   => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
        ], 'Tag berhasil dibuat.');
    }

    // ── DELETE /api/v1/admin/tags/{id} ────────────────────────────
    // Admin: hapus tag (tag akan otomatis lepas dari semua artikel)
    public function destroy(Request $request, int $id): JsonResponse
    {
        $tag = Tag::withCount('articles')->find($id);

        if (!$tag) {
            return $this->notFound('Tag tidak ditemukan.');
        }

        // Detach dari semua artikel dulu sebelum hapus
        $tag->articles()->detach();
        $tag->delete();

        activity()->causedBy($request->user())->withProperties(['name' => $tag->name])->log('delete_tag');

        return $this->success(null, 'Tag berhasil dihapus.');
    }
}