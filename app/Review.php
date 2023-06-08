<?php

namespace App;

use OwenIt\Auditing\Contracts\Auditable;

class Review extends SharedModel implements Auditable{

    use \OwenIt\Auditing\Auditable;

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

    public function track(){
        return $this->belongsTo(Track::class);
    }

    protected function asJson($value){
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

}
