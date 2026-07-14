<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();
        return view('admin-category', compact('categories'));
    }

    // --- Kategori CRUD ---

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Hapus kategori (soft delete akan juga menghapus subkategori secara cascade)
        $category->delete();

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil dihapus.');
    }

    // --- Subkategori CRUD (via AJAX atau inline) ---

    public function storeSubcategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subcategories',
        ]);

        $category->subcategories()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.category')->with('success', 'Subkategori berhasil ditambahkan.');
    }

    public function updateSubcategory(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subcategories,name,' . $subcategory->id,
        ]);

        $subcategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.category')->with('success', 'Subkategori berhasil diperbarui.');
    }

    public function destroySubcategory(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.category')->with('success', 'Subkategori berhasil dihapus.');
    }
}