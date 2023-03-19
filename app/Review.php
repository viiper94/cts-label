<?php

namespace App;

class Review extends SharedModel{

    protected $fillable = [
        'track_id',
        'sort_id',
        'author',
        'score',
        'review',
        'location',
        'source',
        'visible'
    ];

    protected function asJson($value){
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

}
