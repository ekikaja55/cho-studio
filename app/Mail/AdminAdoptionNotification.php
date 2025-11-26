<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Adoption; // <-- TAMBAHKAN INI

class AdminAdoptionNotification extends Mailable 
{
    use Queueable, SerializesModels;

    // TAMBAHKAN properti publik ini
    public $adoption;

    /**
     * Create a new message instance.
     */
    public function __construct(Adoption $adoption) // <-- MODIFIKASI INI
    {
        $this->adoption = $adoption; // <-- TAMBAHKAN INI
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Subjek untuk Admin
        $subject = "New Adoption Received: " . ($this->adoption->gallery->title ?? 'Artwork #' . $this->adoption->gallery_id);

        return new Envelope(
            subject: $subject, // <-- MODIFIKASI INI
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Buat template email BARU khusus untuk Admin
        // Contoh: 'mails.admin_notification'
        return new Content(
            view: 'mail.admin_notification', // <-- MODIFIKASI INI
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}