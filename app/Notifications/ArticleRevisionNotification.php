<?php

// FILE: app/Notifications/ArticleRevisionNotification.php

namespace App\Notifications;

use App\Models\Article;
use App\Models\ArticleRevision;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ArticleRevisionNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Article $article,
        public ArticleRevision $revision
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Artikel Perlu Direvisi — AKSARA')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Artikel Anda memerlukan revisi sebelum dapat dipublikasikan.')
            ->line('Judul: ' . $this->article->title)
            ->line('Bagian yang perlu direvisi: ' . ($this->revision->section ?? 'Umum'))
            ->line('Prioritas: ' . strtoupper($this->revision->priority))
            ->line('Catatan admin: ' . $this->revision->notes)
            ->when($this->revision->deadline, fn ($mail) => $mail->line('Deadline: ' . $this->revision->deadline->format('d M Y')))
            ->line('Silakan perbaiki artikel dan submit ulang.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'        => 'article_revision',
            'article_id'  => $this->article->id,
            'title'       => $this->article->title,
            'revision_id' => $this->revision->id,
            'notes'       => $this->revision->notes,
            'priority'    => $this->revision->priority,
            'deadline'    => $this->revision->deadline?->toDateString(),
            'message'     => 'Artikel "' . $this->article->title . '" perlu direvisi. ' . $this->revision->notes,
        ];
    }
}