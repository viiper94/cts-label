<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolTeacher extends Model{

    protected $table = 'school';
    protected $casts = [
        'visible' => 'boolean'
    ];

}
