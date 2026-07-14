<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsLog extends Model
{
    use HasFactory;

    protected $table = 'analytics_logs';
    protected $fillable = [
        'user_id', 
        'article_id', 
        'type', 
        'value'
    ];
}