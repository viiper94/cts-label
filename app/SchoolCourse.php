<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SchoolCourse extends School implements Auditable{

    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'course_alt',
        'lang',
        'sort_id',
        'visible'
    ];

}
