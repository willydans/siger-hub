<?php

// FILE: app/Models/Attachment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $fillable = [
        'article_id', 'uploaded_by', 'original_name', 'file_name',
        'file_path', 'disk', 'mime_type', 'file_size', 'file_type', 'download_count',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('attachments.download', $this->id);
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }

    public function incrementDownload(): void
    {
        $this->increment('download_count');
        $this->article?->increment('downloads_count');
    }
}