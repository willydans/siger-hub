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
        'no_hp', 'bio', 'avatar', 'role', 'email_verified_at', 'opd',
        'joined_at', 'preferences'
    ];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'preferences' => 'array',
        'joined_at' => 'datetime',
    ];
    public function articles() { return $this->hasMany(Article::class); }
}