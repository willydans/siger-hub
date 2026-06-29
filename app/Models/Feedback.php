<?php
// FILE: app/Models/Feedback.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['user_id','article_id','assigned_to','type','note','status'];

    public function user()       { return $this->belongsTo(User::class); }
    public function article()    { return $this->belongsTo(Article::class); }
    public function assignee()   { return $this->belongsTo(User::class, 'assigned_to'); }
}