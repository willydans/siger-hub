<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        'article_id'
    ];

    // Relasi ke User (opsional, jika ingin dipanggil $like->user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}