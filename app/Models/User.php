<?php

// FILE: app/Models/User.php
// Update dari Step 3 — tambah: role accessor, google_id, bidang, jabatan, bio, joined_at, preferences
// PENTING: accessor 'role' menjembatani CheckRole middleware temanmu dengan Spatie Permission

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
//use Spatie\Activitylog\Traits\CausesActivity;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'opd_id',
        'avatar',
        'phone',
        'nip',
        'google_id',
        'bidang',
        'jabatan',
        'bio',
        'joined_at',
        'preferences',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'joined_at'         => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'preferences'       => 'array',
        ];
    }

    // Override supaya pakai email verifikasi berbahasa Indonesia
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    // ── ROLE ACCESSOR ──────────────────────────────────────────────
    // Ini kunci integrasi: CheckRole middleware temanmu cek $user->role (string)
    // Accessor ini membaca dari Spatie getRoleNames() sehingga:
    // - Spatie tetap jalan untuk API (RBAC sesuai judul KP)
    // - $user->role tetap return 'admin'/'staff'/'user' untuk web routes temanmu
    public function getRoleAttribute(): string
    {
        $roles = $this->getRoleNames();
        if ($roles->isEmpty()) return 'user';

        // Prioritas: admin > staff > user
        if ($roles->contains('admin')) return 'admin';
        if ($roles->contains('staff')) return 'staff';
        return 'user';
    }

    // Setter accessor — digunakan saat SocialiteController set $user->role = 'user'
    // Intercept dan translate ke Spatie assignRole supaya tidak crash
    public function setRoleAttribute(string $value): void
    {
        // Tidak simpan ke DB (tidak ada kolom role), tapi assign ke Spatie
        // Hanya berlaku kalau user sudah ada di DB (bukan saat create)
        if ($this->exists) {
            $this->syncRoles([$value]);
        }
    }

    // ── RELATIONSHIPS ──────────────────────────────────────────────

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Article::class, 'bookmarks')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function articleViews()
    {
        return $this->hasMany(ArticleView::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    // ── HELPERS ────────────────────────────────────────────────────

    public function isAdmin(): bool { return $this->hasRole('admin'); }
    public function isStaff(): bool { return $this->hasRole('staff'); }
    public function isUser(): bool  { return $this->hasRole('user'); }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D8ABC&color=fff';
    }
    public function markAllNotificationsAsRead()
    {
        return \App\Models\Notification::where('user_id', $this->id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]); // Mengubah nilai is_read menjadi 1 (sudah dibaca)
    }

    /**
     * Hapus semua notifikasi milik user ini
     */
    public function deleteAllNotifications()
    {
        return \App\Models\Notification::where('user_id', $this->id)->delete();
    }

    /**
     * Hitung jumlah notifikasi yang belum dibaca
     * (Bisa dipanggil di Blade menggunakan: Auth::user()->unread_notifications_count)
     */
    public function getUnreadNotificationsCountAttribute()
    {
        return \App\Models\Notification::where('user_id', $this->id)
            ->where('is_read', 0)
            ->count();
    }
}