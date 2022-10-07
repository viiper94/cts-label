<?php

namespace App;

use App\Mail\Emailing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EmailingQueue extends Model{

    protected $table = 'email_queue';

    protected $fillable = [
        'channel_id',
        'from',
        'to',
        'subject',
        'name',
    ];

    protected $casts = [
        'sent' => 'boolean'
    ];

    public function channel(){
        return $this->hasOne('App\EmailingChannel', 'id', 'channel_id');
    }

    public function recipient(){
        return $this->hasOne('App\EmailingContact', 'email', 'to');
    }

    public static function send(){
        $in_queue = EmailingQueue::whereSent('0')->take(5)->get();
        foreach($in_queue as $mail){
            $mail->sent = true;
            $mail->save();
            Mail::to($mail->to)->send(new Emailing($mail));
        }
        return true;
    }

}
