<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyViolationWarning extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $violationType;


    public function __construct(User $user, string $violationType)
    {
        $this->user = $user;
        $this->violationType = $violationType;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Peringatan: Anda Terlambat Presensi Masuk Hari Ini',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.daily-violation',
            with: [
                'user' => $this->user,
                'violationType' => $this->violationType,
            ],
        );
    }
}
