<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ZipArchive;

class Feedback extends SharedModel{

    protected $table = 'feedback';
    protected $casts = [
        'tracks' => 'array',
        'visible' => 'boolean',
        'emailing_sent' => 'boolean'
    ];
    public $fillable = [
        'feedback_title',
        'description_en',
        'description_ua',
        'description_ru',
        'visible'
    ];
    public $file_path = 'audio/feedback';

    public function ftracks(){
        return $this->hasMany(FeedbackTrack::class);
    }

    public function release(){
        return $this->belongsTo('App\Release');
    }

    public function results(){
        return $this->hasMany('App\FeedbackResult', 'feedback_id');
    }

    public function related(){
        return $this->belongsToMany('App\Feedback', 'related_feedback', 'feedback_id', 'related_id');
    }

    public function LQDir() :string{
        return is_dir(public_path('/audio/feedback/'.$this->slug.'/96/')) ? '96' : '320';
    }

    public function HQDir() :string{
        return is_dir(public_path('/audio/feedback/'.$this->slug.'/320/')) ? '320' : '96';
    }

    public function saveTracks(Request $request, $new = false){
        $files = array();
        if($request->file('tracks')){
            foreach($request->file('tracks') as $key => $file){
                foreach($file as $bitrate => $item){
                    if ($item->isValid()){
                        $filename = Str::slug(explode('.', $item->getClientOriginalName())[0]);
                        $filename .= $bitrate == 96 ? '.LOFI.' : '.';
                        $filename .= $item->getClientOriginalExtension();

                        $item->move(public_path('audio/feedback/'.$this->slug.'/'.$bitrate), $filename);
                        $files[$key][$bitrate] = $filename;
                    }
                }
            }
        }
        foreach($request->post('tracks') as $key => $item){
            $track = $new || !isset($item['id']) ?
                new FeedbackTrack() :
                FeedbackTrack::with('feedback')->find($item['id']);
            $track->name = $item['name'];
            if(isset($files[$key]['320'])){
                if(!$new && $track->file_320 && $track->hasHQFile()){
                    unlink(public_path($track->filePath()));
                }
                $track->file_320 = $files[$key]['320'];
            }
            if(isset($files[$key]['96'])){
                if(!$new && $track->file_96 && $track->hasLQFile()){
                    unlink(public_path($track->filePath(lq: true)));
                }
                $track->file_96 = $files[$key]['96'];
            }
            $track->feedback_id = $this->id;
            if($new && $this->release && isset($item['id'])){
                $track->track_id = $item['id'];
            }
            $track->save();
        }
    }

    public function hasArchive() :bool{
        return $this->archive_name && file_exists(public_path('audio/feedback/').$this->slug.'/'.$this->archive_name);
    }

    public function archiveTracks() :bool|string{
        $old = public_path('audio/feedback/'.$this->slug.'/').$this->archive_name;
        if(is_file($old)){
            unlink($old);
        }

        $zip = new ZipArchive();
        $filename = $this->slug.'.zip';

        if($zip->open(public_path('/audio/feedback/'.$this->slug.'/'.$filename), ZipArchive::CREATE) !== true){
            return false;
        }

        $zip->addEmptyDir(htmlentities(trim($this->feedback_title)));
        foreach($this->ftracks as $track){
            $zip->addFile(public_path('audio/feedback/'.$this->slug.'/'.$this->HQDir()).'/'.$track->file_320,
                htmlentities(trim($this->feedback_title)).'/'.$track->file_320);
        }
        $zip->close();
        return $filename;
    }

    public static function getPeaks($track): ?string{
        if(isset($track->peaks)){
            if(empty(json_decode($track->peaks))){
                return null;
            }else return $track->peaks;
        }else{
            return null;
        }
    }

}
