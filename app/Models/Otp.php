<?php

// FILE: app/Models/Otp.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = ['user_id', 'otp_code', 'expires_at', 'is_used'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_used'    => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired();
    }
}