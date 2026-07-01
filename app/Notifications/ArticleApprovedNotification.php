<?php

// FILE: app/Notifications/ArticleApprovedNotification.php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ArticleApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public Article $article) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Artikel Disetujui — AKSARA')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Artikel Anda telah disetujui dan dipublikasikan.')
            ->line('Judul: ' . $this->article->title)
            ->action('Lihat Artikel', url('/articles/' . $this->article->slug))
            ->line('Terima kasih atas kontribusi Anda!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'        => 'article_approved',
            'article_id'  => $this->article->id,
            'title'       => $this->article->title,
            'slug'        => $this->article->slug,
            'message'     => 'Artikel "' . $this->article->title . '" telah disetujui dan dipublikasikan.',
        ];
    }
}