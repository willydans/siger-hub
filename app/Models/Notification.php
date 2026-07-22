<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     */
    protected $table = 'notifications';

    /**
     * Kolom yang boleh diisi (Mass Assignable).
     * Pastikan semua kolom di sini sesuai dengan migrasi tabel `notifications`.
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
     * Jika Anda ingin menerapkan praktik keamanan terbaik, gunakan $guarded
     * sebagai pelindung agar tidak ada field yang tidak terdaftar di $fillable
     * yang bisa diisi secara massal (alternatif dari $fillable).
     * (Opsional, tidak mengubah fungsi saat ini)
     */
    // protected $guarded = [];

    /**
     * Casting tipe data.
     * Memastikan 'is_read' selalu diakses sebagai boolean (true/false).
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi ke model User (Penerima notifikasi).
     * Digunakan untuk eager loading: `Notification::with('user')`
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Article (Jika notifikasi berkaitan dengan artikel tertentu).
     * Digunakan untuk eager loading: `Notification::with('article')`
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}