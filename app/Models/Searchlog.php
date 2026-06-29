<?php
// FILE: app/Models/SearchLog.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id','keyword','result_count','ip_address','searched_at'];
    protected function casts(): array { return ['searched_at' => 'datetime']; }

    public function user() { return $this->belongsTo(User::class); }
}