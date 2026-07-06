<?php

namespace App\Notifications;

use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $article;
    protected $staff;

    /**
     * Create a new notification instance.
     */
    public function __construct(Article $article, User $staff)
    {
        $this->article = $article;
        $this->staff = $staff;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Kirim via Email dan juga simpan ke Database (agar muncul di halaman Notifikasi Admin)
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Artikel Baru Perlu Review: ' . $this->article->title)
            ->greeting('Halo Admin,')
            ->line('Seorang Staff telah mengirimkan artikel baru untuk direview.')
            ->line('**Judul Artikel:** ' . $this->article->title)
            ->line('**Penulis:** ' . $this->staff->name)
            ->line('**Kategori:** ' . $this->article->category)
            ->action('Lihat & Review Artikel', route('admin.pending-approval')) // Pastikan route ini ada di web.php admin
            ->line('Terima kasih telah menggunakan SIGER-Hub.');
    }

    /**
     * Get the array representation of the notification (untuk Database).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'approval', // Agar ikonnya Approval di halaman notifikasi
            'title'      => 'Staff ' . $this->staff->name . ' mengirim artikel baru.',
            'message'    => 'Judul: "' . $this->article->title . '". Segera lakukan review.',
            'link'       => route('admin.pending-approval'), // Link jika Admin klik notifikasi
            'is_read'    => false,
        ];
    }
}