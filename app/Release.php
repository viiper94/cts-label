<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model{

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'release_date'
    ];

    protected $casts = [
        'visible' => 'boolean'
    ];

}
