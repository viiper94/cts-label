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

}
