<?php

// FILE: app/Models/User.php
// Ganti seluruh isi file ini

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\CausesActivity;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, CausesActivity;

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'opd_id',
        'avatar',
        'phone',
        'nip',
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
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
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

    // ── HELPERS ────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isStaff(): bool
    {
        return $this->hasRole('staff');
    }

    public function isUser(): bool
    {
        return $this->hasRole('user');
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // Default avatar pakai UI Avatars (no external dependency)
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D8ABC&color=fff';
    }
}