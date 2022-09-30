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
        $data_to_encrypt = [
            'email' => $this->mail->to,
            'from' => $this->mail->from,
            'channel_id' => $this->mail->channel->id
        ];
        $hash = Crypt::encryptString(json_encode($data_to_encrypt));
        return $this->from($this->mail->from, 'CTS Records')
                    ->subject($this->mail->subject)
                    ->markdown('emails.emailing.ade', [
                        'name' => $this->mail->name,
                        'hash' => $hash
                    ]);
    }
}
