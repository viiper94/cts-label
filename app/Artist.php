<?php

namespace App;

class Artist extends SharedModel{

    protected $fillable = [
        'name',
        'link',
        'description_en',
        'description_ru',
        'description_ua',
    ];

}
