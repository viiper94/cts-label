<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model{

    protected $casts = [
        'data' => 'array'
    ];

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
