<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolCourse extends Model{

    protected $table = 'school';
    protected $casts = [
        'visible' => 'boolean'
    ];
    protected $fillable = [
        'name',
        'course_alt',
        'lang'
    ];

}
