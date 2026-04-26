<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendLoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $adminName,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode Verifikasi Login Admin - DKM Masjid',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.send_login_otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
