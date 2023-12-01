<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistContact extends Model{
    use HasFactory;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'artist_cv_id'
    ];

    public function cv(){
        return $this->belongsTo(ArtistCv::class);
    }

}
