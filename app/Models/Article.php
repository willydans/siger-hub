<?php

// FILE: app/Models/Article.php
// FINAL — Kompatibel dengan API dan Frontend, bebas bentrok relasi

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Article extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        // ── Kolom API (backend kamu) ───────────────────────────────
        'user_id', 'category_id', 'opd_id',
        'title', 'slug', 'thumbnail', 'content',
        'status', 'visibility', 'version',
        'meta_title', 'meta_description', 'keywords',
        'references', 'published_at',

        // ── Kolom Statistik (Sesuai dengan struktur Database saat ini)
        'views', 'downloads', 'rating', 'comments_count',
        'views_count', 'downloads_count', // (Tetap dijaga jika API lama masih insert ke sini)

        // ── Kolom Frontend (controller temanmu) ───────────────────
        'category',       
        'subcategory',    
        'opd_unit',       
        'tags_json',      
        'attachments_json',
        'doc_code',
        'valid_from',
        'valid_until',
        'language',
        'estimated_read_time',
        'progress',
        'relations',
    ];

    protected function casts(): array
    {
        return [
            'published_at'        => 'datetime',
            'valid_from'          => 'date',
            'valid_until'         => 'date',
            'views'               => 'integer',
            'downloads'           => 'integer',
            'views_count'         => 'integer',
            'downloads_count'     => 'integer',
            'rating'              => 'float',
            'comments_count'      => 'integer',
            'tags_json'           => 'array',
            'attachments_json'    => 'array',
            'relations'           => 'array',
            'progress'            => 'integer',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'visibility', 'version'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // ── ACCESSOR ALIAS untuk kompatibilitas silang ─────────────────

    // Jika API backend kamu secara eksplisit mencari $article->views_count
    public function getViewsCountAttribute()
    {
        return $this->attributes['views'] ?? 0;
    }

    // Jika API backend kamu secara eksplisit mencari $article->downloads_count
    public function getDownloadsCountAttribute()
    {
        return $this->attributes['downloads'] ?? 0;
    }

    public function getFeaturedImageAttribute(): ?string
    {
        return $this->thumbnail_url;
    }

    public function getRatingAvgAttribute(): float
    {
        return round($this->ratings()->avg('value') ?? 0, 1);
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->author?->name ?? 'Unknown';
    }

    public function getCategoryNameAttribute(): ?string
    {
        return $this->category_id
            ? $this->category?->name
            : $this->category;
    }

    // ── RELATIONSHIPS ──────────────────────────────────────────────

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag')->withTimestamps();
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

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // PERBAIKAN: Diubah dari views() menjadi articleViews() agar tidak bentrok dengan nama kolom
    public function articleViews()
    {
        return $this->hasMany(ArticleView::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // ── SCOPES ─────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePubliclyVisible($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByOpd($query, $opdId)
    {
        return $query->where('opd_id', $opdId);
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->whereFullText(['title', 'content', 'keywords'], $keyword);
    }

    // ── HELPERS ────────────────────────────────────────────────────

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->ratings()->avg('value') ?? 0, 1);
    }

    public function incrementView(): void
    {
        // PERBAIKAN: Increment difokuskan pada kolom 'views' yang ada di tabel
        $this->increment('views');
    }
}