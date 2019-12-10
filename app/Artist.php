<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model{

    protected $guarded = [
        'id',
        'sort_id',
        'image',
        'visible',
        'edit_artist',
        'search-by'
    ];

    public static function getLatestSortId(){
        $artist = Artist::select('sort_id')->orderBy('sort_id', 'desc')->first()->toArray();
        return $artist['sort_id'];
    }

}
