<?php

// FILE: app/Models/Article.php

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
        'user_id',
        'category_id',
        'opd_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'status',
        'visibility',
        'version',
        'views_count',
        'downloads_count',
        'meta_title',
        'meta_description',
        'keywords',
        'references',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at'   => 'datetime',
            'views_count'    => 'integer',
            'downloads_count'=> 'integer',
        ];
    }

    // Spatie ActivityLog — catat perubahan field ini
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'visibility', 'version'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // ── RELATIONSHIPS ──────────────────────────────────────────────

    public function author()
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
    return $this->belongsToMany(Tag::class, 'article_tag');
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

    public function views()
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
        $this->increment('views_count');
    }
}