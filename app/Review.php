<?php

namespace App;

class Review extends SharedModel{

    protected $casts = [
        'data' => 'array'
    ];

    protected function asJson($value){
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public $defaultReview = [
        'reviews' => [0 => [
            'author' => '',
            'location' => '',
            'review' => '',
            'score' => 5,
        ]],
        'additional' => [0 => [
            'author' => '',
            'location' => '',
        ]],
    ];

}
