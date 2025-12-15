<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountActivated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $status;
    public $subjek;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $status, string $subjek)
    {
        $this->user = $user;
        $this->status = $status;
        $this->subjek = $subjek;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjek, // Menggunakan subjek dinamis
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.account-activated',
            with: [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'status' => $this->status,
                'user' => $this->user,
            ],
        );
    }
}
