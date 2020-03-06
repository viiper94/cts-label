<?php

namespace App;

use Illuminate\Http\Request;
use ZipArchive;

class Feedback extends SharedModel{

    protected $table = 'feedback';
    protected $casts = [
        'tracks' => 'array',
        'visible' => 'boolean'
    ];
    public $file_path = 'audio/feedback';

    public function release(){
        return $this->belongsTo('App\Release');
    }

    public function results(){
        return $this->hasMany('App\FeedbackResult', 'feedback_rid', 'release_id');
    }

    public function related(){
        return $this->belongsToMany('App\Feedback', 'related_feedback', 'feedback_rid', 'related_rid', 'release_id', 'release_id');
    }

    public function LQDir(){
        return is_dir(public_path('/audio/feedback/'.$this->release->id.'/96/')) ? '96' : '320';
    }

    public function HQDir(){
        return is_dir(public_path('/audio/feedback/'.$this->release->id.'/320/')) ? '320' : '96';
    }

    public function renewRelatedFeedback($ids){
        $this->related()->detach();
        if($ids === null) return true;
        foreach($ids as $id){
            $this->related()->attach($id);
        }
        return true;
    }

    public function saveTracks(Request $request){
        $path = public_path($this->file_path).'/'.$this->release_id;
        $tracks = array();
        foreach($request->post('tracks') as $key => $track){
            $tracks[$key]['title'] = $track['title'];
            if(isset($this->tracks[$key][96])) $tracks[$key][96] = $this->tracks[$key][96];
            if(isset($this->tracks[$key][320])) $tracks[$key][320] = $this->tracks[$key][320];
        }
        if($request->file('tracks')){
            foreach($request->file('tracks') as $key => $file){
                foreach($file as $bitrate => $item){
                    if ($item->isValid()) {
                        // deleting old file
                        if(isset($this->tracks[$key][$bitrate]) && is_file($path.'/'.$bitrate.'/'.$this->tracks[$key][$bitrate])){
                            unlink($path.'/'.$bitrate.'/'.$this->tracks[$key][$bitrate]);
                        }
                        // save new file
                        $item->move(public_path('audio/feedback/'.$this->release->id.'/'.$bitrate), $item->getClientOriginalName());
                        $tracks[$key][$bitrate] = $item->getClientOriginalName();
                    }
                }
            }
        }
        foreach($this->tracks as $key => $track){
            if(!isset($request->post('tracks')[$key])){
                if(isset($this->tracks[$key][96]) && is_file($path.'/96/'.$this->tracks[$key][96])){
                    unlink($path.'/96/'.$this->tracks[$key][96]);
                }
                if(isset($this->tracks[$key][320]) && is_file($path.'/320/'.$this->tracks[$key][320])){
                    unlink($path.'/320/'.$this->tracks[$key][320]);
                }
            }
        }
        return $tracks;
    }

    public function archiveTracks(){
        $old = public_path('audio/feedback/'.$this->release->id.'/').$this->archive_name;
        if(is_file($old)){
            unlink($old);
        }

        $zip = new ZipArchive();
        $filename = htmlentities(str_replace(' ', '_', trim($this->feedback_title))).'.zip';

        if($zip->open(public_path('/audio/feedback/'.$this->release->id.'/'.$filename), ZipArchive::CREATE) !== true){
            return false;
        }

        $zip->addEmptyDir(htmlentities(trim($this->feedback_title)));
        foreach($this->tracks as $track){
            $zip->addFile(public_path('audio/feedback/'.$this->release->id.'/'.$this->HQDir()).'/'.$track[$this->HQDir()],
                htmlentities(trim($this->feedback_title)).'/'.$track[$this->HQDir()]);
        }
        $zip->close();
        return $filename;
    }

}
