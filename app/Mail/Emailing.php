<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
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

    private function getSubject() :string{
        if(isset($this->mail->data['template']) && $this->mail->data['template'] === 'feedback'){
            $subject = $this->mail->feedback->feedback_title;
            if($this->mail->feedback->release->genre) $subject .= '. Genre: '.$this->mail->feedback->release->genre;
            $subject .= '. Download & feedback!';
        }
        return $subject ?? $this->mail->subject;
    }

    private function getHash() :string{
        return isset($this->mail->data['unsubscribe']) && $this->mail->data['unsubscribe'] ?
            Crypt::encryptString(json_encode([
                'email' => $this->mail->to,
                'from' => $this->mail->from,
                'channel_id' => $this->mail->channel->id
            ]))
            : false;
    }

    private function getView() :string{
        return 'emails.emailing.'.$this->mail->data['template'];
    }

}
