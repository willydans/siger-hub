<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ArticleStatusLog extends Model {
    protected $fillable = ['article_id', 'user_id', 'old_status', 'new_status', 'reason'];
}