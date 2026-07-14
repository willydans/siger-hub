<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * ✅ PERBAIKAN PENTING: Paksa Laravel memakai tabel 'feedbacks' (jamak)
     * karena kita baru saja membuat migrasi dengan nama tabel tersebut.
     */
    protected $table = 'feedbacks';

    protected $fillable = [
        'article_id',
        'user_id',
        'feedback_type',
        'status',
        'message',
    ];

    /**
     * Relasi ke artikel yang diberi feedback
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Relasi ke user yang memberikan feedback
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}