<?php
// FILE: app/Models/UserActivity.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = [
        'user_id', 'article_id', 'type', 'description', 'ip_address', 'user_agent'
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function article() { return $this->belongsTo(Article::class); }
}