<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'type',
        'description',
        'ip_address',
        'user_agent'
    ];

    /**
     * Relasi ke tabel articles.
     * Memungkinkan kita memanggil $activity->article
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}