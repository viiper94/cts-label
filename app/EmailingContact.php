<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailingContact extends Model{

    use SoftDeletes;

    protected $table = 'email_contacts';

    protected $fillable = ['name', 'email', 'company', 'position', 'additional', 'phone', 'website', 'country', 'company_foa'];

    public function channels(){
        return $this->belongsToMany('App\EmailingChannel', 'email_channels_contacts', 'contact_id', 'channel_id');
    }

}
