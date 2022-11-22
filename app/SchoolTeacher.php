<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolTeacher extends School{

    protected $fillable = [
        'name',
        'lang',
        'teacher_hinfo',
        'teacher_binfo',
        'sort_id',
        'visible'
    ];

}
