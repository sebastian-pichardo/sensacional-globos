<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $subscriberEmail) {}

    public function envelope(): Envelope
    {
        $from = config('globos.mail.from');

        return new Envelope(
            from: is_string($from) && $from !== ''
                ? new Address($from, (string) config('globos.name'))
                : null,
            replyTo: [new Address($this->subscriberEmail)],
            subject: 'Nuevo registro al newsletter',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.newsletter-subscription',
        );
    }
}
