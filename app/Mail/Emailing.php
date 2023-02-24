<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class Emailing extends Mailable{

    use Queueable, SerializesModels;

    public function __construct(public $mail){}

    public function envelope(){
        return new Envelope(
            from: new Address($this->mail->from, 'CTS Records'),
            subject: $this->getSubject()
        );
    }

    public function content(){
        return new Content(
            markdown: $this->getView(),
            with: [
                'name' => $this->mail->name,
                'hash' => $this->getHash()
            ]
        );
    }

    public function attachments(){
        return [
//            Attachment::fromPath(public_path('webinar/Showcase-Festivals.pdf'))
//                ->as('Showcase-Festivals.pdf')
//                ->withMime('application/pdf')
        ];
    }

    private function getSubject() :string{
        if($this->mail->template === 'feedback'){
            $subject = $this->mail->feedback->feedback_title;
            if($this->mail->feedback->release?->genre) $subject .= '. Genre: '.$this->mail->feedback->release->genre;
            $subject .= '. Download & feedback!';
        }
        return $subject ?? $this->mail->subject;
    }

    private function getHash() :string{
        return $this->mail->unsubscribe ?
            Crypt::encryptString(json_encode([
                'email' => $this->mail->to,
                'from' => $this->mail->from,
                'channel_id' => $this->mail->channel->id
            ]))
            : false;
    }

    private function getView() :string{
        return 'emails.emailing.'.$this->mail->template;
    }

}
