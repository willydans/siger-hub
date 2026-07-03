<?php

// FILE: app/Http/Controllers/Api/CategoryController.php
// Public: list kategori (untuk dropdown & filter di frontend)
// Admin: CRUD kategori + subkategori

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ApiResponse;

    // ── GET /api/v1/categories ─────────────────────────────────────
    // Public: list semua kategori aktif (dengan jumlah artikel)
    public function index(): JsonResponse
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id') // hanya kategori induk
            ->with('children')
            ->withCount('articles')
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return $this->success(CategoryResource::collection($categories));
    }

    // ── GET /api/v1/categories/{id} ────────────────────────────────
    // Public: detail kategori dengan subkategori & artikel count
    public function show(int $id): JsonResponse
    {
        $category = Category::with(['parent', 'children'])
            ->withCount('articles')
            ->find($id);

        if (!$category) {
            return $this->notFound('Kategori tidak ditemukan.');
        }

        return $this->success(new CategoryResource($category));
    }

    // ── POST /api/v1/admin/categories ─────────────────────────────
    // Admin: buat kategori baru
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        // Cegah kategori menjadi child dari dirinya sendiri atau membuat loop
        if ($request->filled('parent_id')) {
            $parent = Category::find($request->parent_id);
            if (!$parent) {
                return $this->notFound('Kategori induk tidak ditemukan.');
            }
            // Hanya izinkan 1 level subkategori (parent tidak boleh punya parent sendiri)
            if ($parent->parent_id !== null) {
                return $this->error('Subkategori tidak bisa dijadikan induk kategori lain (maksimal 2 level).', 422);
            }
        }

        $category = Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'parent_id'   => $request->parent_id,
            'icon'        => $request->icon,
            'color'       => $request->color ?? '#6B7280',
            'description' => $request->description,
            'order'       => $request->order ?? 0,
            'is_active'   => true,
        ]);

        activity()->causedBy($request->user())->performedOn($category)->log('create_category');

        return $this->created(
            new CategoryResource($category->load('parent')),
            'Kategori berhasil dibuat.'
        );
    }

    // ── PUT /api/v1/admin/categories/{id} ─────────────────────────
    // Admin: update kategori
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->notFound('Kategori tidak ditemukan.');
        }

        $data = $request->only(['parent_id', 'icon', 'color', 'description', 'order', 'is_active']);

        if ($request->filled('name')) {
            $data['name'] = $request->name;
            $data['slug'] = Str::slug($request->name);
        }

        // Cegah kategori menjadi child dari dirinya sendiri
        if (isset($data['parent_id']) && $data['parent_id'] == $id) {
            return $this->error('Kategori tidak bisa menjadi induk dirinya sendiri.', 422);
        }

        $category->update($data);

        activity()->causedBy($request->user())->performedOn($category)->log('update_category');

        return $this->success(
            new CategoryResource($category->fresh(['parent', 'children'])->loadCount('articles')),
            'Kategori berhasil diperbarui.'
        );
    }

    // ── DELETE /api/v1/admin/categories/{id} ──────────────────────
    // Admin: hapus kategori (tidak bisa hapus kalau masih ada artikel)
    public function destroy(Request $request, int $id): JsonResponse
    {
        $category = Category::withCount('articles')->find($id);

        if (!$category) {
            return $this->notFound('Kategori tidak ditemukan.');
        }

        if ($category->articles_count > 0) {
            return $this->error(
                'Kategori tidak bisa dihapus karena masih memiliki ' . $category->articles_count . ' artikel. Pindahkan artikel terlebih dahulu.',
                422
            );
        }

        // Hapus subkategori juga kalau ada (cascade)
        $category->children()->delete();
        $category->delete();

        activity()->causedBy($request->user())->withProperties(['name' => $category->name])->log('delete_category');

        return $this->success(null, 'Kategori berhasil dihapus.');
    }
}