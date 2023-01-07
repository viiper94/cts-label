<?php

namespace App;

class Release extends SharedModel{

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'release_date'
    ];

    protected $casts = [
        'visible' => 'boolean'
    ];

    protected $fillable = [
        'title',
        'release_number',
        'beatport',
        'youtube',
        'description_en',
        'description_ru',
        'description_ua',
        'tracklist',
        'genre',
        'visible'
    ];

    public function related(){
        return $this->belongsToMany('App\Release', 'related_releases', 'release_id', 'related_id');
    }

    public function tracks(){
        return $this->belongsToMany(Track::class, 'track_release');
    }

    public function feedback(){
        return $this->hasOne('App\Feedback');
    }

    public function getUsefulText($text){
        return trim(str_replace('&nbsp;', ' ', strip_tags(htmlspecialchars_decode($text))));
    }

    public function detectActiveDescriptionLang($count = false){
        $available_descriptions = array();
        $this->description_en ? $available_descriptions[] = 'en' : false;
        $this->description_ua ? $available_descriptions[] = 'ua' : false;
        $this->description_ru ? $available_descriptions[] = 'ru' : false;
        if($count){
            return count($available_descriptions);
        }

        $cookie_lang = $_COOKIE['lang'] ?? null;
        $default_lang = 'en';

        if($cookie_lang && $this['description_'.$cookie_lang]){
            return $cookie_lang;
        }else{
            if($this['description_'.$default_lang]){
                return $default_lang;
            }else if($available_descriptions){
                return $available_descriptions[0];
            }else{
                return false;
            }
        }
    }

    public function getTracksCount(){
        if($this->tracklist){
            $lines_arr = preg_split('/\r\n|\n|\r/',$this->tracklist);
            return count($lines_arr);
        }
        return 1;
    }

    public static function generateReleaseNumber(): string{
        $last = Release::select('release_number')->latest()->first();
        preg_match('/CTS([0-9]{1,3})([0-9]{2})3/', $last->release_number, $matches);
        return 'CTS'.((int)$matches[1]+1).date('y').'3';
    }

}
