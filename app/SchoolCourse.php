<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolCourse extends School{

    protected $fillable = [
        'name',
        'course_alt',
        'lang'
    ];

}
