<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $feedback, public $result){}

    public function envelope(){
        return new Envelope(
            from: new Address($this->result->email, $this->result->name),
            subject: 'Feedback to release '. $this->feedback->feedback_title,
        );
    }

    public function content(){
        return new Content(
            markdown: 'emails.feedback.result',
        );
    }

}
