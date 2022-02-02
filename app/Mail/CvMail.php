<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CvMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cv;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cv)
    {
        $this->cv = $cv;
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
