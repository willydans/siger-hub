<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->withCount('articles')->latest()->paginate(10);
        $allCategories = Category::orderBy('name', 'asc')->get();
        return view('admin-category', compact('categories', 'allCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            // Validasi minimal 2 subkategori
            'subcategories' => 'required|array|min:2',
            'subcategories.*' => 'required|string|max:255',
        ], [
            'name.unique' => 'Nama kategori ini sudah digunakan, silakan pilih nama lain.',
            'subcategories.min' => 'Minimal harus ada 2 subkategori.',
            'subcategories.*.required' => 'Nama subkategori tidak boleh kosong.'
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Simpan Subkategori
        foreach ($request->subcategories as $sub) {
            $category->subcategories()->create([
                'name' => $sub,
                'slug' => Str::slug($sub)
            ]);
        }

        return redirect()->route('admin.category')->with('success', 'Kategori dan Subkategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'subcategories' => 'required|array|min:2',
            'subcategories.*' => 'required|string|max:255',
        ], [
            'name.unique' => 'Nama kategori ini sudah digunakan, silakan pilih nama lain.',
            'subcategories.min' => 'Minimal harus ada 2 subkategori.',
            'subcategories.*.required' => 'Nama subkategori tidak boleh kosong.'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Hapus subkategori lama dan buat yang baru (sinkronisasi data)
        $category->subcategories()->delete();
        foreach ($request->subcategories as $sub) {
            $category->subcategories()->create([
                'name' => $sub,
                'slug' => Str::slug($sub)
            ]);
        }

        return redirect()->route('admin.category')->with('success', 'Kategori dan Subkategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->articles()->count() > 0) {
            return redirect()->route('admin.category')->with('error', 'Gagal! Kategori tidak dapat dihapus karena masih memiliki artikel.');
        }

        $category->delete(); // Karena migration subcategories memakai onDelete('cascade'), subkategori akan otomatis terhapus

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil dihapus!');
    }
}