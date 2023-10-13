<?php

namespace App;

use App\Mail\Emailing;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Contracts\Auditable;
use Symfony\Component\Mailer\Exception\TransportException;

class EmailingQueue extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable;

    protected $table = 'email_queue';

    protected $fillable = [
        'channel_id',
        'from',
        'from_name',
        'to',
        'subject',
        'name',
        'data',
        'feedback_id',
        'unsubscribe',
        'template',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'smtp_send_rate',
    ];

    protected $casts = [
        'unsubscribe' => 'boolean',
        'sent' => 'boolean',
        'data' => 'array',
    ];

    public function channel(){
        return $this->hasOne('App\EmailingChannel', 'id', 'channel_id');
    }

    public function feedback(){
        return $this->hasOne('App\Feedback', 'id', 'feedback_id');
    }

    public function recipient(){
        return $this->hasOne('App\EmailingContact', 'email', 'to');
    }

    public static function send(){
        $rate = env('MAIL_SEND_RATE', '4');
        $in_queue = EmailingQueue::with('channel', 'recipient', 'feedback', 'feedback.release', 'feedback.related')
            ->whereSent('0')->orderBy('sort', 'asc')->take($rate)->get();
        foreach($in_queue as $mail){
            App::setLocale($mail->channel->lang);
            if(!$mail->template) continue;
            try{
                Mail::to($mail->to)->send(new Emailing($mail));
                $mail->error_code = null;
                $mail->error_message = null;
                $mail->sent = true;
                $mail->save();
            }catch(Exception $e){
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

    public static function getEta($numEmailsInQueue) :string{
        $rate = env('MAIL_SEND_RATE', '4'); // assumed sending rate of 4 emails per minute
        $minutes = ceil($numEmailsInQueue / $rate); // calculate number of minutes needed to send all emails
        $hours = floor($minutes / 60); // calculate number of hours needed to send all emails
        $minutes = $minutes % 60; // calculate number of remaining minutes
        $eta = '';
        if ($hours > 0) {
            $eta .= $hours . ' '.trans('emailing.queue.h').' ';
        }
        $eta .= $minutes . ' '.trans('emailing.queue.m'); // format ETA string
        return $eta;
    }

}
