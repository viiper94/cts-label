<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class EmailingContact extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable, SoftDeletes, HasFactory;

    protected $table = 'email_contacts';

    protected $casts = [
        'error_log' => 'array'
    ];

    protected $fillable = [
        'name',
        'full_name',
        'email',
        'company',
        'position',
        'additional',
        'phone',
        'website',
        'country',
        'company_foa'
    ];

    public function channels(){
        return $this->belongsToMany(
            'App\EmailingChannel',
            'email_channels_contacts',
            'contact_id',
            'channel_id'
        );
    }

}
