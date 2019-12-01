<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model{

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'release_date'
    ];

    protected $casts = [
        'visible' => 'boolean'
    ];

    protected $guarded = [
        'id',
        'sort_id',
        'image',
        'release_date',
        'visible',

        'edit_release',
        'search-by',
        'related'
    ];

    public function related(){
        return $this->belongsToMany('App\Release', 'related_releases', 'release_id', 'related_id');
    }

    public static function getLatestSortId(){
        $release = Release::select('sort_id')->orderBy('sort_id', 'desc')->first()->toArray();
        return $release['sort_id'];
    }

}
