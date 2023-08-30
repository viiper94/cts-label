<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Track extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'artists',
        'name',
        'mix_name',
        'remixers',
        'composer',
        'isrc',
        'bpm',
        'genre',
        'length',
        'youtube',
        'beatport_id',
        'beatport_slug',
        'beatport_release_id',
        'beatport_wave',
        'beatport_sample',
        'beatport_sample_start',
        'beatport_sample_end'
    ];

    public $casts = [
        'remixers' => 'array',
    ];

    public function releases(){
        return $this->belongsToMany(Release::class, 'track_release');
    }

    public function reviews(){
        return $this->hasMany(Review::class)->whereNotNull('review');
    }

    public function also_supported(){
        return $this->hasMany(Review::class)->whereNull('review');
    }

    public function length(): Attribute{
        return Attribute::make(
            get: function($value){
                return Track::millisecondsToMinutes($value);
            },
            set: fn ($value) => stripos($value, ':') ? Track::minutesToMilliseconds($value) : $value,
        );
    }

    public function beatportSampleStart(): Attribute{
        return Attribute::make(
            get: function($value){
               return Track::millisecondsToMinutes($value);
            },
            set: fn ($value) => stripos($value, ':') ? Track::minutesToMilliseconds($value) : $value,
        );
    }

    public function beatportSampleEnd(): Attribute{
        return Attribute::make(
            get: function($value){
               return Track::millisecondsToMinutes($value);
            },
            set: fn ($value) => stripos($value, ':') ? Track::minutesToMilliseconds($value) : $value,
        );
    }

    private static function millisecondsToMinutes($value): string{
        if(!$value) return '';
        $sec = floor($value / 1000);
        $minutes = floor($sec / 60);
        $seconds = $sec - ($minutes*60);
        return Carbon::parse('00:'.$minutes.':'.$seconds)->format('i:s');
    }

    public static function minutesToMilliseconds($value): string{
        if(!$value) return '';
        $exploded = explode(':', $value);
        $minutes = (int) $exploded[0];
        $seconds = (int) $exploded[1];
        return $minutes*60000 + $seconds*1000;
    }

    public static function generateISRCCode(): string{
        $like = 'UA-CT1-'.date('y').'-%';
        $latest = Track::select('isrc')->where('isrc', 'like', $like)->orderBy('isrc', 'desc')->first();
        if(!$latest) return 'UA-CT1-'.date('y').'-00001';
        else{
            $isrc = explode('-', $latest->isrc);
            return 'UA-CT1-'.date('y').'-'.sprintf("%'.05d", (int) $isrc[3] + 1);
        }
    }

    public function getFullTitle(): string{
        $title = $this->artists . ' - ' . $this->name;
        if($this->mix_name) $title .= ' (' . $this->mix_name . ')';
        return $title;
    }

    public function lengthToIso8601() :string{
        $length_arr = explode(':', $this->length);
        $m = (int)$length_arr[0];
        $s = (int)$length_arr[1];
        return 'PT'.$m.'M'.$s.'S';
    }

    public function getBeatportLink() :string|bool{
        if(!$this->beatport_id || !$this->beatport_slug) return false;
        return 'https://www.beatport.com/track/'.$this->beatport_slug.'/'.$this->beatport_id;
    }

}
