<?php

namespace App;

use OwenIt\Auditing\Contracts\Auditable;

class SchoolTeacher extends School implements Auditable{

    use \OwenIt\Auditing\Auditable;

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
