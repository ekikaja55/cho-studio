<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Adoption; // <-- TAMBAHKAN INI

class AdoptionConfirmation extends Mailable 
{
    use Queueable, SerializesModels;

    // TAMBAHKAN properti publik ini
    public $adoption;

    /**
     * Create a new message instance.
     *
     * Terima data $adoption saat Mailable dibuat
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
        // Ambil subjek dinamis dari kode lama Anda
        $subject = "Your Adoption Submission: " . ($this->adoption->gallery->title ?? 'Artwork #' . $this->adoption->gallery_id);
        
        return new Envelope(
            subject: $subject, // <-- MODIFIKASI INI
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Arahkan ke template email yang sudah Anda punya
        return new Content(
            view: 'mail.new_adoption', // <-- MODIFIKASI INI
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