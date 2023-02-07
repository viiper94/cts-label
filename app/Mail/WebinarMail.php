<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WebinarMail extends Mailable{
    use Queueable, SerializesModels;

    public function __construct(public $contact){}

    public function envelope()
    {
        return new Envelope(
            from: new Address(env('INFO_EMAIL', 'info@cts-label.com'), 'CTS Records'),
            subject: 'Реєстрація на вебінар "Маркетинг та менеджмент артиста у кризові часи"',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.event',
            with: ['contact' => $this->contact]
        );
    }

    public function attachments()
    {
        return [];
    }
}
