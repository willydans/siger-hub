<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'subject_id',
        'subject_type',
        'causer_id',
        'description',
        'properties',
        'created_at'
    ];

    // Relasi ke user (jika causer adalah user)
    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}