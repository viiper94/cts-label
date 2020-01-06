<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends SharedModel{

    protected $table = 'school';
    protected $casts = [
        'visible' => 'boolean'
    ];

}
