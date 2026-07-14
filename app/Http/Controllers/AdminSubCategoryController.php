<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSubcategoryController extends Controller
{
    public function index()
{
    // Ambil kategori beserta subkategorinya
    $categories = Category::with('subcategories')->latest()->paginate(10);
    
    // Ambil semua kategori untuk dropdown di form "Tambah Sub Kategori"
    $allCategories = Category::orderBy('name', 'asc')->get();
    
    return view('admin-category', compact('categories', 'allCategories'));
}

public function store(Request $request)
{
    $request->validate(['name' => 'required|string|max:255|unique:categories,name']);
    Category::create([
        'name' => $request->name,
        'slug' => \Illuminate\Support\Str::slug($request->name),
    ]);
    return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
}

public function update(Request $request, $id)
{
    $request->validate(['name' => 'required|string|max:255|unique:categories,name,'.$id]);
    $category = Category::findOrFail($id);
    $category->update([
        'name' => $request->name,
        'slug' => \Illuminate\Support\Str::slug($request->name),
    ]);
    return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
}

    public function destroy($id)
{
    $sub = \App\Models\Subcategory::findOrFail($id);
    $sub->delete();
    
    // Kembali ke halaman admin/category, BUKAN ke halaman subkategori
    return redirect()->route('admin.category')->with('success', 'Sub Kategori berhasil dihapus!');
}
}