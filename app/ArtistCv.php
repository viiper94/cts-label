<?php

namespace App;

use App\Enums\CvStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistCv extends Model{
    use HasFactory;

    protected $fillable = [
        'main_contact_name', 'main_contact_phone', 'main_contact_email', 'tracks_to_sign'
    ];
    protected $casts = [
        'status' => CvStatus::class,
        'tracks_to_sign' => 'array',
    ];

    public function artists_info(){
        return $this->hasMany(ArtistContact::class);
    }

    public function createDocument() :string{

        $filename = $this->created_at->format('YmdHi').'-'.md5(time()).'.pdf';
        $doc = Pdf::loadView('admin.artists.cv.pdf', ['cv' => $this]);

        if(!is_dir(public_path('cv'))){
            mkdir(public_path('cv'));
        }
        $doc->save(public_path('cv/'.$filename));

        return $filename;
    }

}
