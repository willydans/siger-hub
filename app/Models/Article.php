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
        'attachments' => 'array', // ✅ Sudah benar!
        'relations' => 'array',
        'rating_avg' => 'float',
        'rating' => 'integer',
        'published_at' => 'datetime',
        'progress' => 'integer',
        'valid_from' => 'date',
        'valid_until' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }
}