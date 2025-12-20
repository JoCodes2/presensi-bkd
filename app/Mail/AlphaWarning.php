<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlphaWarning extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $date;
    public $type;

    public function __construct($user, $date, $type)
    {
        $this->user = $user;
        $this->date = $date;
        $this->type = $type;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Peringatan Keras: Tercatat Tidak Absen (Alpha) pada ' . $this->date,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.alpha-warning',
            with: [
                'user' => $this->user,
                'date' => $this->date,
                'type' => $this->type,
            ],
        );
    }
}
