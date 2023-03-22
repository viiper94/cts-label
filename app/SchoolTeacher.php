<?php

namespace App;

class SchoolTeacher extends School{

    protected $fillable = [
        'name',
        'lang',
        'teacher_hinfo',
        'teacher_binfo',
        'course_alt',
        'sort_id',
        'visible'
    ];

}
