<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model{

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

    public static function getLatestSortId(){
        $review = Review::select('sort_id')->orderBy('sort_id', 'desc')->first()->toArray();
        return $review['sort_id'];
    }

}
