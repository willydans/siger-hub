<?php

// FILE: app/Notifications/VerifyEmailNotification.php
// Custom notification supaya email verifikasi berbahasa Indonesia

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmailBase
{
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Alamat Email — AKSARA')
            ->greeting('Halo!')
            ->line('Terima kasih telah mendaftar di AKSARA (Sistem Manajemen Pengetahuan Diskominfotik Provinsi Lampung).')
            ->line('Silakan klik tombol di bawah untuk memverifikasi alamat email Anda.')
            ->action('Verifikasi Email', $url)
            ->line('Link verifikasi ini berlaku selama 60 menit.')
            ->line('Jika Anda tidak membuat akun ini, abaikan email ini.');
    }
}