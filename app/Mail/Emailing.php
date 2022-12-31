<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class Emailing extends Mailable{

    use Queueable, SerializesModels;

    public function __construct(public $mail){}

    public function build(){
        $hash = isset($this->mail->data['unsubscribe']) && $this->mail->data['unsubscribe'] ?
            Crypt::encryptString(json_encode([
                'email' => $this->mail->to,
                'from' => $this->mail->from,
                'channel_id' => $this->mail->channel->id
            ]))
            : false;
        if(isset($this->mail->data['template']) && $this->mail->data['template'] === 'feedback'){
            $subject = $this->mail->feedback->feedback_title;
            if($this->mail->feedback->release->genre) $subject .= '. Genre: '.$this->mail->feedback->release->genre;
            $subject .= '. Download & feedback!';
        }
        return $this->from($this->mail->from, 'CTS Records')
                    ->subject($subject ?? $this->mail->subject)
                    ->view('emails.emailing.'.$this->mail->data['template'], [
                        'name' => $this->mail->name,
                        'hash' => $hash
                    ]);
    }
}
