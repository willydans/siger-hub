<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Pastikan sesuai dengan nama tabel di database Anda.
     */
    protected $table = 'notifications';

    /**
     * Kolom yang boleh diisi (Mass Assignable).
     * Sangat penting agar data `title`, `message`, `type` tersimpan dengan benar!
     */
    protected $fillable = [
        'user_id',
        'article_id',
        'type',
        'title',
        'message',
        'url',
        'is_read',
    ];

    /**
     * Casting tipe data.
     * Memastikan 'is_read' selalu diakses sebagai boolean (true/false).
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi ke model User (Penerima notifikasi).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Article (Jika notifikasi berkaitan dengan artikel tertentu).
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}