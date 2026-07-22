<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Kolom yang boleh diisi (mass assignment).
     */
    protected $fillable = [
        'user_id',
        'reviewed_by_user_id', // ✅ Tambahkan kolom ini agar bisa diisi saat Admin melakukan Review
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
        'comments_count',
        'revision_notes', // ✅ PERBAIKAN: kolom ini sebelumnya tidak ada di
                           // $fillable, jadi setiap kali AdminArticleController
                           // ::revision() memanggil $article->update([...
                           // 'revision_notes' => ...]), Laravel diam-diam
                           // membuang field ini tanpa error — makanya selalu
                           // tersimpan sebagai null walau request-nya sukses.
    ];

    /**
     * Casting tipe data.
     */
    protected $casts = [
        'tags'          => 'array',
        'attachments'   => 'array',
        'relations'     => 'array',
        'rating_avg'    => 'float',
        'rating'        => 'integer',
        'published_at'  => 'datetime',
        'progress'      => 'integer',
        'valid_from'    => 'date',
        'valid_until'   => 'date',
        'deleted_at'    => 'datetime', // ✅ tambahan eksplisit untuk konsistensi
    ];

    // ========== RELATIONSHIPS ==========

    /**
     * Relasi ke user (penulis).
     * Didefinisikan eksplisit dengan foreign key 'user_id'.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * ✅ Relasi ke user (Admin yang memberikan review / revisi).
     * Foreign key-nya adalah 'reviewed_by_user_id'.
     */
    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by_user_id');
    }

    /**
     * Relasi many-to-many ke tag.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    /**
     * Relasi ke kategori (menggunakan kolom category sebagai foreign key).
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'name');
    }

    /**
     * Relasi ke komentar.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ========== ACCESSORS ==========

    /**
     * Menampilkan versi dengan fallback.
     */
    public function getVersionAttribute($value)
    {
        return $value ?? '-';
    }

    /**
     * Nama penulis (aman jika user null).
     */
    public function getAuthorNameAttribute()
    {
        return $this->user->name ?? 'Admin';
    }

    /**
     * Tanggal dibuat dengan format d M Y.
     */
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M Y') : '-';
    }

    /**
     * Tanggal publikasi dengan format d M Y.
     */
    public function getPublishedAtFormattedAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : 'Belum dipublikasikan';
    }

    /**
     * Cuplikan (excerpt) – otomatis diambil dari konten jika kosong.
     */
    public function getExcerptAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }
        return Str::limit(strip_tags($this->content), 120);
    }

    /**
     * (Opsional) URL thumbnail yang sudah siap pakai.
     */
    public function getThumbnailUrlAttribute()
    {
        if (!empty($this->thumbnail)) {
            return str_starts_with($this->thumbnail, 'http')
                ? $this->thumbnail
                : asset('storage/' . $this->thumbnail);
        }
        return asset('images/placeholder-article.png');
    }

    // ========== SCOPES ==========

    /**
     * Scope artikel yang sudah dipublikasikan.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    /**
     * Scope filter berdasarkan kategori.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope filter berdasarkan bahasa.
     */
    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    /**
     * Scope artikel yang masih berlaku (valid_from – valid_until).
     */
    public function scopeValid($query)
    {
        $now = now();
        return $query
            ->where(function ($q) use ($now) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', $now);
            });
    }
}