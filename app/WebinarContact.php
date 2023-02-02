<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarContact extends Model{

    protected $fillable = [
        'name',
        'email',
        'tel',
        'type',
        'other',
        'additional',
    ];

}
