<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtistDoc extends Model
{

    protected $table = 'documents';
    
    public function tracks(){
        return $this->belongsToMany('App\Tracks', 'tracks_docs', 'doc_id', 'track_id');
    }

    public function artist(){
        return $this->belongsTo('App\Artists');
    }

}
