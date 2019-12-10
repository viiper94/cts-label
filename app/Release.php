<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model{

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'release_date'
    ];

    protected $casts = [
        'visible' => 'boolean'
    ];

    protected $guarded = [
        'id',
        'sort_id',
        'image',
        'release_date',
        'visible',

        'edit_release',
        'search-by',
        'related'
    ];

    public function related(){
        return $this->belongsToMany('App\Release', 'related_releases', 'release_id', 'related_id');
    }

    public static function getLatestSortId(){
        $release = Release::select('sort_id')->orderBy('sort_id', 'desc')->first()->toArray();
        return $release['sort_id'];
    }

    public function renewRelatedReleases($ids){
        $this->related()->detach();
        if($ids === null) return true;
        foreach($ids as $id){
            $this->related()->attach($id);
        }
        return true;
    }

    public function getUsefulText($text){
        return trim(str_replace('&nbsp;', ' ', strip_tags(htmlspecialchars_decode($text))));
    }

    public function detectActiveDescriptionLang($count = false){
        $available_descriptions = array();
        $this->description_en ? $available_descriptions[] = 'en' : false;
        $this->description_ru ? $available_descriptions[] = 'ru' : false;
        $this->description_ua ? $available_descriptions[] = 'ua' : false;
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

}
