<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class FeedbackResult extends Model{

    protected $to = 'admin@cts.ua';
//    protected $to = 'viiper94@gmail.com';
    protected $fillable = [
        'name',
        'email',
        'comment',
        'rates',
        'best_track',
    ];
    protected $casts = [
        'rates' => 'array',
    ];

    public function sendFeedback($feedback){
        Mail::send('emails.feedback_result', ['feedback' => $feedback, 'result' => $this], function ($m) use ($feedback) {
            $m->from($this->email, $this->name)->to($this->to, 'CTS Admin')->subject('Feedback to release '. $feedback->feedback_title);
        });
    }

}
