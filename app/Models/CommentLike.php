<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $fillable = [
        'comment_id',
        'user_id'
    ];

    // Tidak perlu relasi balik ke Comment atau User karena tabel ini hanya pivot murni.
}