<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'google_id', 'nip', 'bidang', 'jabatan',
        'no_hp', 'bio', 'avatar', 'role_id', 'email_verified_at', 'opd',
        'joined_at', 'preferences'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'preferences' => 'array',
        'joined_at' => 'datetime',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    /**
     * Relasi ke Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi ke Artikel (sebagai penulis)
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * ✅ Relasi ke Notifikasi (menggunakan user_id)
     * Karena tabel notifikasi menggunakan kolom 'user_id', bukan polymorphic.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * ✅ Relasi ke Notifikasi yang BELUM dibaca
     * Memudahkan untuk mengambil semua notifikasi yang belum dibaca oleh user.
     */
    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id')->where('is_read', false);
    }

    /**
     * Relasi ke Bookmark
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Relasi ke UserActivity (Riwayat Aktivitas)
     */
    public function activities()
    {
        return $this->hasMany(UserActivity::class);
    }

    /**
     * Relasi ke Like
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relasi ke Rating
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Relasi ke Komentar
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ==========================================
    // METHOD-METHOD NOTIFIKASI
    // ==========================================

    /**
     * ✅ Tandai SEMUA notifikasi user sebagai telah dibaca.
     */
    public function markAllNotificationsAsRead()
    {
        return $this->notifications()->update(['is_read' => true]);
    }

    /**
     * ✅ Hapus SEMUA notifikasi user.
     */
    public function deleteAllNotifications()
    {
        return $this->notifications()->delete();
    }

    /**
     * ✅ Ambil jumlah notifikasi yang belum dibaca.
     */
    public function getUnreadNotificationsCountAttribute()
    {
        return $this->unreadNotifications()->count();
    }

    // ==========================================
    // HELPER LAINNYA (Opsional)
    // ==========================================

    /**
     * Cek apakah user memiliki role tertentu.
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Cek apakah user adalah staff.
     */
    public function isStaff()
    {
        return $this->hasRole('staff');
    }

    /**
     * Cek apakah user adalah user biasa.
     */
    public function isUser()
    {
        return $this->hasRole('user');
    }
}