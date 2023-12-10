<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CvMail extends Mailable{
    use Queueable, SerializesModels;

    public function __construct(public $cv){}

    public function envelope(){
        return new Envelope(
            from: new Address($this->cv->email, $this->cv->name),
            subject: trans('cv.title'),
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.cv.admin',
        );
    }

    public function attachments()
    {
        return [
            Attachment::fromPath(public_path('cv/'.$this->cv->document))
                ->as('anketa.pdf')
                ->withMime('application/pdf'),
        ];
    }

}
