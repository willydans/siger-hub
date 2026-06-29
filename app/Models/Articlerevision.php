<?php
// FILE: app/Models/ArticleRevision.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ArticleRevision extends Model
{
    protected $fillable = ['article_id','reviewed_by','section','priority','deadline','notes','status'];
    protected function casts(): array { return ['deadline' => 'date']; }

    public function article()  { return $this->belongsTo(Article::class); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
}