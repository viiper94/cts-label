<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $feedback;
    public $result;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($feedback, $result){
        $this->feedback = $feedback;
        $this->result = $result;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.feedback.result')
            ->subject('Feedback to release '. $this->feedback->feedback_title)
            ->from($this->result->email);
    }
}
