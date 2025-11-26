<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdoptionDeliveryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $adoption;

    /**
     * Create a new message instance.
     */
    public function __construct($adoption)
    {
        $this->adoption = $adoption;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $title = $this->adoption->gallery->title;

        return new Envelope(
            subject: "[Cho's Studio] Delivery of Your Adopted Artwork: $title",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.adoption_delivery_mail',
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
