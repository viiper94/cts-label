<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistContact extends Model{
    use HasFactory;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'artist_cv_id'
    ];
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function cv(){
        return $this->belongsTo(ArtistCv::class);
    }

    public static function getFromOld(array $old){
        return ArtistContact::find($old);
    }

}
