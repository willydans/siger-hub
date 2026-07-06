public function toMail($notifiable)
{
    $url = url('/staff/articles');
    return (new MailMessage)
                ->subject('Artikel Anda Disetujui!')
                ->line('Selamat! Artikel Anda telah disetujui oleh Admin.')
                ->action('Lihat Artikel', $url)
                ->line('Terima kasih telah menulis di SIGER-Hub.');
}