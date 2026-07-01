<?php

// FILE: app/Notifications/ArticleRejectedNotification.php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ArticleRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Article $article,
        public string $reason
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Artikel Ditolak — AKSARA')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Artikel Anda tidak dapat dipublikasikan.')
            ->line('Judul: ' . $this->article->title)
            ->line('Alasan penolakan: ' . $this->reason)
            ->line('Silakan hubungi admin untuk informasi lebih lanjut.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'article_rejected',
            'article_id' => $this->article->id,
            'title'      => $this->article->title,
            'reason'     => $this->reason,
            'message'    => 'Artikel "' . $this->article->title . '" ditolak. Alasan: ' . $this->reason,
        ];
    }
}