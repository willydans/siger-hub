<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Notification extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan.
     */
    protected $table = 'notifications';

    /**
     * Kolom yang boleh diisi secara massal.
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
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    /**
     * Relasi ke User (penerima notifikasi).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Article (jika notifikasi terkait artikel).
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // ==========================================
    // SCOPE (Query Filter)
    // ==========================================

    /**
     * Scope untuk mengambil notifikasi yang BELUM dibaca.
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope untuk mengambil notifikasi yang SUDAH dibaca.
     */
    public function scopeRead(Builder $query): Builder
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope untuk filter berdasarkan tipe notifikasi.
     */
    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope untuk filter berdasarkan user.
     */
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    // ==========================================
    // HELPER METHOD
    // ==========================================

    /**
     * Tandai notifikasi sebagai telah dibaca.
     */
    public function markAsRead(): bool
    {
        return $this->update(['is_read' => true]);
    }

    /**
     * Tandai notifikasi sebagai belum dibaca.
     */
    public function markAsUnread(): bool
    {
        return $this->update(['is_read' => false]);
    }

    /**
     * Cek apakah notifikasi sudah dibaca.
     */
    public function isRead(): bool
    {
        return (bool) $this->is_read;
    }

    /**
     * Cek apakah notifikasi belum dibaca.
     */
    public function isUnread(): bool
    {
        return !$this->isRead();
    }
}