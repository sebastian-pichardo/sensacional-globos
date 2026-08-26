<?php

namespace App\Mail;

use App\Models\DecoratorApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DecoratorApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public DecoratorApplication $application) {}

    public function envelope(): Envelope
    {
        $from = config('globos.mail.from');

        return new Envelope(
            from: is_string($from) && $from !== ''
                ? new Address($from, (string) config('globos.name'))
                : null,
            replyTo: [new Address($this->application->email, $this->application->name)],
            subject: 'Nueva inscripción de decorador Sensacional',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.decorator-application',
        );
    }
}
