<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Contracts\Auditable;

class FeedbackResult extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable;

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

}
