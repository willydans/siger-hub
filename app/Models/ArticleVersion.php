<?php
// FILE: app/Models/ArticleVersion.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ArticleVersion extends Model
{
    protected $fillable = ['article_id','created_by','version_number','snapshot','change_summary'];
    protected function casts(): array { return ['snapshot' => 'array']; }

    public function article() { return $this->belongsTo(Article::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}