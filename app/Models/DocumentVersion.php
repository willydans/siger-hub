<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DocumentVersion extends Model {
    protected $fillable = ['article_id', 'user_id', 'version_number', 'content', 'change_log'];
}