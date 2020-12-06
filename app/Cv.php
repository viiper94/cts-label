<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model{

    protected $table = 'cv';
    protected $casts = [
        'birth_date' => 'date'
    ];
    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'dj_name',
        'vk',
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
        'additional_info',
        'learned_about_ctschool',
        'course',
        'what_to_learn',
        'purpose_of_learning',
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

}
