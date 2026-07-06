<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($otpCode, $user)
    {
        $this->otpCode = $otpCode;
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS', 'no-reply@aksara.com'))
                    ->subject('Kode Verifikasi OTP AKSARA')
                    ->view('emails.otp');
    }
}