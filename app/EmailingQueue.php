<?php

namespace App;

use App\Mail\Emailing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;

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
        $in_queue = EmailingQueue::whereSent('0')->orderBy('sort', 'asc')->take(4)->get();
        foreach($in_queue as $mail){
            try{
                Mail::to($mail->to)->send(new Emailing($mail));
                $mail->error_code = null;
                $mail->error_message = null;
                $mail->sent = true;
                $mail->save();
            }catch(TransportException $e){
                if($mail->sort === '1'){
                    $mail->sent = true;
                }
                $mail->sort = 1;
                $mail->error_code = $e->getCode();
                $mail->error_message = $e->getMessage();
                $mail->save();
            }

        }
        return true;
    }

}
