<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EmailingChannel extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable;

    protected $table = 'email_channels';

    protected $fillable = [
        'title',
        'description',
        'from',
        'from_name',
        'subject',
        'template',
        'lang',
        'unsubscribe',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'smtp_send_rate',
    ];

    protected $casts = [
        'unsubscribe' => 'boolean'
    ];

    public function __construct(){
        $this->from = 'info@cts-studio.com';
        $this->from_name = 'CTS Records';
    }

    public function subscribers(){
        return $this->belongsToMany('App\EmailingContact', 'email_channels_contacts', 'channel_id', 'contact_id');
    }

    public function queue(){
        return $this->hasMany('App\EmailingQueue', 'channel_id', 'id');
    }

}
