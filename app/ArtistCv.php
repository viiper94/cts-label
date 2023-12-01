<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistCv extends Model{
    use HasFactory;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'doc'
    ];

    public function cv(){
        return $this->hasMany(ArtistContact::class);
    }

}
