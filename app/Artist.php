<?php

namespace App;

class Artist extends SharedModel{

    protected $guarded = [
        'id',
        'sort_id',
        'image',
        'visible',
        'edit_artist',
        'search-by'
    ];

}
