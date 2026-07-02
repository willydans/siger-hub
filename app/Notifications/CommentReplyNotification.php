<?php

// FILE: app/Notifications/CommentReplyNotification.php
// Dikirim ke pemilik komentar saat ada yang membalas komentarnya

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommentReplyNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Comment $reply,   // komentar balasan (yang baru)
        public Comment $parent   // komentar asli yang dibalas
    ) {}

    public function via(object $notifiable): array
    {
        return ['database']; // hanya database, tidak kirim email untuk reply komentar
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'comment_reply',
            'article_id' => $this->reply->article_id,
            'comment_id' => $this->parent->id,
            'reply_id'   => $this->reply->id,
            'from'       => $this->reply->user->name,
            'message'    => $this->reply->user->name . ' membalas komentar Anda: "' .
                            \Illuminate\Support\Str::limit($this->reply->body, 50) . '"',
        ];
    }
}