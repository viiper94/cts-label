<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Contracts\Auditable;

class FeedbackResult extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'comment',
        'rates',
        'best_track',
        'status'
    ];
    protected $casts = [
        'rates' => 'array',
        'status' => FeedbackResultStatus::class
    ];

}
