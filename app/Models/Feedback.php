<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (Mass Assignment)
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'message',
        'rating',
        'status',
    ];

    /**
     * Relasi ke Model User (jika feedback diberikan oleh user yang login)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}