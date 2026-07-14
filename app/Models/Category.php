<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Kolom yang bisa diisi (Mass Assignment)
     * Sesuaikan jika database Anda belum memiliki kolom parent_id, description, dll.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',  // Untuk membuat kategori bertingkat (induk & anak)
        'is_active',
        'order'
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * ✅ PERBAIKAN UTAMA: Relasi ke Artikel (Berdasarkan Nama Kategori)
     * 
     * Karena tabel `articles` menyimpan kategori sebagai string di kolom `category`,
     * kita menghubungkannya dengan tabel `categories` melalui kolom `name`.
     * Fungsi ini sangat penting agar KnowledgeBaseController bisa memanggil ->withCount('articles')
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'category', 'name');
    }

    /**
     * 🔹 Relasi ke Subkategori (Sesuai dengan kode asli Anda)
     * Jika Anda menggunakan tabel terpisah bernama `subcategories`, gunakan ini.
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * 🔹 Relasi ke Kategori Induk (Parent Category)
     * Berguna jika Anda menggunakan sistem kategori bertingkat (Nested Category)
     * di mana parent_id mengarah ke id kategori lain di tabel yang sama.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * 🔹 Relasi ke Kategori Anak (Children Category)
     * Ini adalah alternatif dari subcategories() jika Anda menggunakan satu tabel Categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}