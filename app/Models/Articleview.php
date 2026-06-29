<?php
// FILE: app/Models/ArticleView.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ArticleView extends Model
{
    public $timestamps = false;
    protected $fillable = ['article_id','user_id','ip_address','user_agent','viewed_at'];
    protected function casts(): array { return ['viewed_at' => 'datetime']; }

    public function article() { return $this->belongsTo(Article::class); }
    public function user()    { return $this->belongsTo(User::class); }
}