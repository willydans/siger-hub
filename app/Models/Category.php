<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon'];

    /**
     * Relasi ke model Article.
     * Menghubungkan kolom 'category' di tabel articles dengan kolom 'name' di tabel categories.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'category', 'name');
    }

    /**
     * Relasi ke model Subcategory (jika ada).
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}