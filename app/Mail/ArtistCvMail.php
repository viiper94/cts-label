<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArtistCvMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $cv){}

    public function envelope(){
        return new Envelope(
            from: new Address($this->cv->main_contact_email, $this->cv->main_contact_name),
            subject: trans('artists.cv.title'),
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.cv.artist_info',
        );
    }

    public function attachments()
    {
        return [
            Attachment::fromPath(public_path('cv/'.$this->cv->doc))
                ->as('CTSRecords_ArtistInfo.pdf')
                ->withMime('application/pdf'),
        ];
    }

}
