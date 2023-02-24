<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailingChannel extends Model{

    protected $table = 'email_channels';
    public $from = 'info@cts-studio.com';

    protected $fillable = [
        'title',
        'description',
        'from',
        'subject',
        'template',
        'lang',
        'unsubscribe'
    ];

    protected $casts = [
        'unsubscribe' => 'boolean'
    ];

    public function subscribers(){
        return $this->belongsToMany('App\EmailingContact', 'email_channels_contacts', 'channel_id', 'contact_id');
    }

    public function queue(){
        return $this->hasMany('App\EmailingQueue', 'channel_id', 'id');
    }

}
