<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UniversalNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     * $data berisi array: ['subject', 'headline', 'message', 'details', dll]
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Mengambil subject dari array data yang dikirim controller
            subject: $this->data['subject'] ?? "Notification from Cho's Studio",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Pastikan file view ini ada di: resources/views/mail/universal_notification.blade.php
            view: 'mail.universal_notification', 
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}