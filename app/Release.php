<?php

namespace App;

use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use ZipArchive;

class Release extends SharedModel implements Auditable{

    use \OwenIt\Auditing\Auditable;

    protected $casts = [
        'visible' => 'boolean',
        'tracklist_show_artist' => 'boolean',
        'tracklist_show_title' => 'boolean',
        'tracklist_show_mix' => 'boolean',
        'tracklist_show_custom' => 'boolean',
        'release_date' => 'datetime',
        'uploaded_on_beatport' => 'boolean',
        'uploaded_on_believe' => 'boolean',
        'uploaded_on_juno' => 'boolean',
        'uploaded_on_google_drive' => 'boolean',
        'promo_upload' => 'boolean',
        'uploaded_on_zip_dj' => 'boolean',
        'uploaded_on_music_worx' => 'boolean',
        'uploaded_on_release_promo' => 'boolean',
        'label_copy_uploaded' => 'boolean',
        'is_emailing_done' => 'boolean',
    ];

    protected $fillable = [
        'title',
        'release_number',
        'exclusive_period',
        'beatport',
        'youtube',
        'description_en',
        'description_ru',
        'description_ua',
        'tracklist',
        'genre',
        'visible',
        'tracklist_show_artist',
        'tracklist_show_title',
        'tracklist_show_mix',
        'tracklist_show_custom',
        'uploaded_on_beatport',
        'uploaded_on_believe',
        'uploaded_on_juno',
        'uploaded_on_google_drive',
        'promo_upload',
        'uploaded_on_zip_dj',
        'uploaded_on_music_worx',
        'uploaded_on_release_promo',
        'label_copy_uploaded',
        'is_emailing_done',
    ];

    public function __construct(){
        parent::__construct();
        $this->tracklist_show_artist = true;
        $this->tracklist_show_title = true;
        $this->tracklist_show_mix = true;
    }

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
        }else if($this['description_'.$default_lang]){
            return $default_lang;
        }else if($available_descriptions){
            return $available_descriptions[0];
        }
        return false;
    }

    public static function generateReleaseNumber(): string{
        $last = Release::select('release_number')->where('release_number', 'like', 'CTS%')->latest()->first();
        preg_match('/CTS([0-9]{1,3})([0-9]{2})3/', $last->release_number, $matches);
        return 'CTS'.((int)$matches[1]+1).date('y').'3';
    }

    public function getStore(): ?string{
        if(stripos($this->beatport, 'beatport.com/')) return 'beatport';
        if(stripos($this->beatport, 'spotify.com/')) return 'spotify';
        if(stripos($this->beatport, 'discogs.com/')) return 'discogs';
        if(stripos($this->beatport, 'cts-label.com/')) return 'cts';
        return null;
    }

    public function getTracklistRow($track): string{
        $string = '';
        if($this->tracklist_show_artist){
            $string .= $track->artists;
        }
        if($this->tracklist_show_artist && $this->tracklist_show_title){
            $string .= ' - ';
        }
        if($this->tracklist_show_title){
            $string .= $track->name;
        }
        if(($this->tracklist_show_title || $this->tracklist_show_artist)
            && $track->mix_name && $this->tracklist_show_mix){
            $string .= ' (';
        }
        if($track->mix_name && $this->tracklist_show_mix){
            $string .= $track->mix_name;
        }
        if(($this->tracklist_show_title || $this->tracklist_show_artist)
            && $track->mix_name && $this->tracklist_show_mix){
            $string .= ')';
        }
        return $string;
    }

    public function createLabelCopy(){
        if(!$this->tracks) return false;
        $dir = $this->release_number.'_'.str_replace([' ', '#'], ['_', ''], $this->title);
        @mkdir(public_path('labelCopy'));
        $path = 'labelCopy/'.$dir;
        if(!is_dir(public_path($path))){
            mkdir(public_path($path));
        }

        $zip = new \ZipArchive();
        $zip_filename = $dir.'.zip';
        if($zip->open(public_path($path.'/'.$zip_filename), ZipArchive::CREATE) !== true){
            return false;
        }
        $zip->addEmptyDir($dir);

        foreach($this->tracks as $track){
            $doc = Pdf::loadView('admin.releases.pdf.label_copy', [
                'track' => $track,
                'release' => $this
            ]);

            $filename = $track->artists.' - '.$track->name;
            if($track->mix_name) $filename .= ' ('.$track->mix_name.')';
            $filename_pdf =  $filename.'.pdf';

            $doc->save($path.'/'.$filename_pdf);

            $zip->addFile(public_path($path.'/'.$filename_pdf), $dir.'/'.$filename_pdf);

        }

        $zip->close();
        return '/'.$path.'/'.$zip_filename;
    }

    public function saveImage(UploadedFile $image){
        $name = $this->id .'-'. Str::slug($this->title);
        $this->image = $name.'_500.jpg';
        $this->image_270 = $name.'_270.jpg';
        $file = Image::load($image->getPathname())->quality(75);
        $file->format(Manipulations::FORMAT_JPG)->width(270)->save(public_path('images/releases/').$this->image_270);
        $file->format(Manipulations::FORMAT_JPG)->width(500)->save(public_path('images/releases/').$this->image);
    }

    public function deleteImages(){
        foreach([$this->image ?? null, $this->image_270 ?? null] as $src){
            $path = public_path('images/releases/').$src;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
        }
    }

    public function hasUnfinishedUploads($count = false) :bool|array{
        $today = Carbon::today();
        $result = array();

        if($this->uploaded_on_beatport){
            if(!$this->uploaded_on_believe){
                $result['uploaded_on_believe'] = [
                    'class' => $today->lte($this->release_date) ? 'warning' : 'danger',
                    'msg' => trans('releases.needs_uploaded_before') . ' ' . $this->release_date->isoFormat('LL')
                ];
            }
            if(!$this->uploaded_on_juno){
                $result['uploaded_on_juno'] = [
                    'class' => $today->lte($this->release_date->addDays(7)) ? 'warning' : 'danger',
                    'msg' => trans('releases.needs_uploaded_before') . ' ' . $this->release_date->addDays(7)->isoFormat('LL')
                ];
            }
            if(!$this->uploaded_on_google_drive && $today->gte($this->release_date->addDays(14))){
                $result['uploaded_on_google_drive'] = [
                    'class' => $today->eq($this->release_date->addDays(14)) ? 'warning' : 'danger',
                    'msg' => trans('releases.needs_uploaded_on') . ' ' . $this->release_date->addDays(14)->isoFormat('LL')
                ];
            }
            if(!$this->label_copy_uploaded && $today->gte($this->release_date->addDays(14))){
                $result['label_copy_uploaded'] = [
                    'class' => $today->eq($this->release_date->addDays(14)) ? 'warning' : 'danger',
                    'msg' => trans('releases.needs_uploaded_on') . ' ' . $this->release_date->addDays(14)->isoFormat('LL')
                ];
            }
        }
        if($this->promo_upload){
            if(!$this->uploaded_on_zip_dj && $today->gte($this->release_date->subDay())){
                $result['uploaded_on_zip_dj'] = [
                    'class' => $today->eq($this->release_date->subDay()) ? 'warning' : 'danger',
                    'msg' => trans('releases.needs_uploaded_on') . ' ' . $this->release_date->subDay()->isoFormat('LL')
                ];
            }
            if(!$this->uploaded_on_music_worx){
                $result['uploaded_on_music_worx'] = [
                    'class' => $today->lte($this->release_date->subDay()) ? 'warning' : 'danger',
                    'msg' => trans('releases.needs_uploaded_before') . ' ' . $this->release_date->subDay()->isoFormat('LL')
                ];
            }
            if(!$this->uploaded_on_release_promo){
                $result['uploaded_on_release_promo'] = [
                    'class' => $today->lte($this->release_date->subDay()) ? 'warning' : 'danger',
                    'msg' => trans('releases.needs_uploaded_before') . ' ' . $this->release_date->subDay()->isoFormat('LL')
                ];
            }
        }

        if($count){
            $collection = collect($result);

            $dangerElements = $collection->filter(function ($item) {
                return $item['class'] === 'danger';
            });

            return count($dangerElements) > 0;
        }

        return $result;
    }

}
