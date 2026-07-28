<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // ── Kolom Asli Milikmu & Kombinasi Frontend/Backend Teman ──
        'user_id',
        'category_id', // Tambahan
        'category',
        'subcategory',
        'subcategory_id',
        'opd_id', // Tambahan
        'opd_unit',
        'tags',
        'tags_json', // Tambahan
        'title',
        'slug',
        'content',
        'excerpt',
        'thumbnail',
        'visibility',
        'meta_title', // Tambahan
        'meta_keywords',
        'keywords', // Tambahan
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
        'attachments_json', // Tambahan
        'relations',
        'references', // Tambahan
        
        // ── Kolom Statistik ──
        'views',
        'views_count', // Tambahan
        'downloads',
        'downloads_count', // Tambahan
        'rating',
        'rating_avg',
        'rating_count',
        'likes',
        'likes_count',
        'bookmarks',
        'comments_count'
    ];

    /**
     * Menggunakan method casts() mengikuti standar model temanmu.
     */
    protected function casts(): array
    {
        return [
            'tags'                => 'array',
            'tags_json'           => 'array',
            'attachments'         => 'array',
            'attachments_json'    => 'array',
            'relations'           => 'array',
            'rating_avg'          => 'float',
            'rating'              => 'float', // Diubah ke float mengikuti teman
            'views'               => 'integer',
            'downloads'           => 'integer',
            'views_count'         => 'integer',
            'downloads_count'     => 'integer',
            'comments_count'      => 'integer',
            'published_at'        => 'datetime',
            'progress'            => 'integer',
            'valid_from'          => 'date',
            'valid_until'         => 'date'
        ];
    }

    // ========== RELATIONSHIPS ==========

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alias untuk user
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag')->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function comments()
    {
        // Hanya ambil komentar utama (parent) sesuai model temanmu
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function revisions()
    {
        return $this->hasMany(ArticleRevision::class)->latest();
    }

    public function versions()
    {
        return $this->hasMany(ArticleVersion::class)->orderByDesc('version_number');
    }

    public function bookmarkedByUsers()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function articleViews()
    {
        return $this->hasMany(ArticleView::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // ========== ACCESSORS & ALIASES ==========

    public function getVersionAttribute($value)
    {
        return $value ?? '-';
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->user->name ?? $this->author?->name ?? 'Admin';
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M Y') : '-';
    }

    public function getPublishedAtFormattedAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : 'Belum dipublikasikan';
    }

    public function getExcerptAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }
        return Str::limit(strip_tags($this->content), 120);
    }

    public function getViewsCountAttribute()
    {
        return $this->attributes['views'] ?? 0;
    }

    public function getDownloadsCountAttribute()
    {
        return $this->attributes['downloads'] ?? 0;
    }

    public function getFeaturedImageAttribute(): ?string
    {
        return $this->thumbnail_url;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getRatingAvgAttribute(): float
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->rating_avg;
    }

    public function getCategoryNameAttribute(): ?string
    {
        return $this->category_id ? $this->category?->name : $this->category;
    }

    // ========== SCOPES ==========

    public function scopePublished($query)
    {
        // Kombinasi logic: status published dan tanggal rilis sudah ada
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function scopePubliclyVisible($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeByCategory($query, $category)
    {
        // Bisa handle baik ID maupun String Name (dari penggabungan)
        if (is_numeric($category)) {
            return $query->where('category_id', $category);
        }
        return $query->whereHas('category', fn ($q) => $q->where('name', $category));
    }

    public function scopeByOpd($query, $opdId)
    {
        return $query->where('opd_id', $opdId);
    }

    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->whereFullText(['title', 'content', 'keywords'], $keyword);
    }

    public function scopeValid($query)
    {
        $now = now();
        return $query->where(function ($q) use ($now) {
            $q->whereNull('valid_from')->orWhere('valid_from', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('valid_until')->orWhere('valid_until', '>=', $now);
        });
    }

    // ========== HELPERS ==========

    public function incrementView(): void
    {
        $this->increment('views');
    }
}