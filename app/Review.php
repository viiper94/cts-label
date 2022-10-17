<?php

namespace App;

class Review extends SharedModel{

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'track',
        'visible'
    ];

    public function __construct(){
        $this->data = [
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

    protected function asJson($value){
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

}
