<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailingChannel extends Model{

    protected $table = 'email_channels';

    protected $fillable = ['title', 'description', 'from', 'subject', 'template'];

    public function subscribers(){
        return $this->belongsToMany('App\EmailingContact', 'email_channels_contacts', 'channel_id', 'contact_id');
    }

}
