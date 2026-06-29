<?php
// FILE: app/Models/Comment.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','article_id','parent_id','body','is_approved'];
    protected function casts(): array { return ['is_approved' => 'boolean']; }

    public function user()    { return $this->belongsTo(User::class); }
    public function article() { return $this->belongsTo(Article::class); }
    public function parent()  { return $this->belongsTo(Comment::class, 'parent_id'); }
    public function replies() { return $this->hasMany(Comment::class, 'parent_id')->latest(); }
}