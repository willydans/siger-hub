<?php
// FILE: app/Models/Category.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['parent_id','name','slug','icon','color','description','order','is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function parent()    { return $this->belongsTo(Category::class, 'parent_id'); }
    public function children()  { return $this->hasMany(Category::class, 'parent_id'); }
    public function articles()  { return $this->hasMany(Article::class); }
}