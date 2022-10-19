<?php

namespace App;

class StudioService extends SharedModel{

    protected $table = 'studio';
    protected $casts = [
        'visible' => 'boolean'
    ];
    protected $fillable = [
        'name',
        'service_alt',
        'lang',
        'sort_id',
        'visible'
    ];

}
