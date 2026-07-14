<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category',
        'subcategory',
        'opd_unit',
        'tags',
        'title',
        'slug',
        'content',
        'excerpt',
        'thumbnail',
        'visibility',
        'meta_keywords',
        'meta_description',
        'estimated_read_time',
        'language',
        'version',
        'doc_code',
        'valid_from',
        'valid_until',
        'status',
        'published_at',
        'progress',
        'attachments',
        'relations',
        'views',
        'downloads',
        'rating',
        'rating_avg',
        'rating_count',
        'likes',
        'bookmarks',
        'likes_count',
        'comments_count'
    ];

    protected $casts = [
        'tags' => 'array',
        'attachments' => 'array',
        'relations' => 'array',
        'rating_avg' => 'float',
        'rating' => 'integer',
        'published_at' => 'datetime',
        'progress' => 'integer',
        'valid_from' => 'date',
        'valid_until' => 'date'
    ];

    // ========== RELATIONSHIPS ==========

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'name');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ========== ACCESSORS ==========

    /**
     * Fallback version if null.
     */
    public function getVersionAttribute($value)
    {
        return $value ?? '-';
    }

    /**
     * Nama penulis / admin, aman jika user tidak ada.
     * Di template bisa langsung pakai: $article->author_name
     */
    public function getAuthorNameAttribute()
    {
        return $this->user->name ?? 'Admin';
    }

    /**
     * Format tanggal publikasi sesuai kebutuhan template.
     */
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M Y') : '-';
    }

    /**
     * Format tanggal publish khusus jika pakai published_at.
     */
    public function getPublishedAtFormattedAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : 'Belum dipublikasikan';
    }

    // ========== SCOPES ==========

    /**
     * Artikel yang sudah dipublikasikan.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    /**
     * Filter berdasarkan kategori.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Filter berdasarkan bahasa.
     */
    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    /**
     * Hanya artikel yang masih berlaku.
     */
    public function scopeValid($query)
    {
        $now = now();
        return $query->where(function ($q) use ($now) {
            $q->whereNull('valid_from')->orWhere('valid_from', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('valid_until')->orWhere('valid_until', '>=', $now);
        });
    }
}