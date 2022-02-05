<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class FeedbackResult extends Model{

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
