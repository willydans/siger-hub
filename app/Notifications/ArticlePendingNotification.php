<?php

// FILE: app/Notifications/ArticlePendingNotification.php
// Dikirim ke ADMIN saat staff submit artikel

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ArticlePendingNotification extends Notification
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
            ->subject('Artikel Baru Menunggu Persetujuan — AKSARA')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Ada artikel baru yang menunggu persetujuan Anda.')
            ->line('Judul: ' . $this->article->title)
            ->line('Penulis: ' . $this->article->author->name)
            ->line('OPD: ' . ($this->article->opd->name ?? '-'))
            ->action('Review Artikel', url('/admin/articles/' . $this->article->id))
            ->line('Silakan review dan berikan keputusan Anda.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'        => 'article_pending',
            'article_id'  => $this->article->id,
            'title'       => $this->article->title,
            'author'      => $this->article->author->name,
            'message'     => 'Artikel "' . $this->article->title . '" dari ' . $this->article->author->name . ' menunggu persetujuan.',
        ];
    }
}