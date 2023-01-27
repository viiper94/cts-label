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
            subject: 'Анкета на обучение в CTSchool',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.cv.admin',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.cv.admin')->subject('Анкета на обучение в CTSchool')->from($this->cv->email);
    }
}
