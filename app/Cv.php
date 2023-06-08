<?php

namespace App;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Cv extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable;

    protected $table = 'cv';
    protected $casts = [
        'birth_date' => 'date'
    ];
    protected $fillable = [
        'name',
        'email',
        'dj_name',
        'instagram',
        'facebook',
        'soundcloud',
        'other_social',
        'phone_number',
        'address',
        'education',
        'job',
        'sound_engineer_skills',
        'sound_producer_skills',
        'dj_skills',
        'music_genres',
        'os',
        'equipment',
        'additional_info',
        'learned_about_ctschool',
        'course',
        'what_to_learn',
        'purpose_of_learning',
        'status'
    ];
    public $statusCodes = [
        0 => [
            'name' => 'Новая',
            'labelClass' => 'label-danger'
        ],
        1 => [
            'name' => 'На рассмотрении',
            'labelClass' => 'label-warning'
        ],
        2 => [
            'name' => 'Рассмотрена',
            'labelClass' => 'label-success'
        ],
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getStatus(){
        return key_exists($this->status, $this->statusCodes) ? $this->statusCodes[$this->status] : $this->statusCodes[0];
    }

    public function createDocument() :string{

        $filename = $this->created_at->format('YmdHi').'-'.md5(time()).'.pdf';
        $doc = Pdf::loadView('admin.school.cv.pdf.cv_document', ['cv' => $this]);

        if(!is_dir(public_path('cv'))){
            mkdir(public_path('cv'));
        }
        $doc->save(public_path('cv/'.$filename));

        return $filename;
    }

}
