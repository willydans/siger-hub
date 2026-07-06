<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'query', 'results_count', 'clicks', 
        'clicked_article_id', 'user_agent', 'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clickedArticle()
    {
        return $this->belongsTo(Article::class, 'clicked_article_id');
    }
}