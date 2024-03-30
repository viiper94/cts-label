<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class FeedbackTrack extends SharedModel implements Auditable{

    use \OwenIt\Auditing\Auditable, HasFactory;

    public $fillable = [
        'name',
        'file_320',
        'file_96',
        'track_id',
        'feedback_id',
    ];
    private $audioDir = 'audio/feedback';

    public function track(){
        return $this->hasOne(Track::class);
    }

    public function feedback(){
        return $this->belongsTo(Feedback::class);
    }

    public function filePath($lq = false) :string{
        $path = [
            $this->audioDir,
            $this->feedback->slug,
            $lq ? $this->feedback->LQDir() : $this->feedback->HQDir(),
            $lq ? $this->file_96 : $this->file_320
        ];
        return '/'.implode('/', $path);
    }

    public function hasLQFile() :bool{
        return is_file(public_path($this->filePath(true)));
    }

    public function hasHQFile() :bool{
//        dd(public_path($this->filePath()));
        return is_file(public_path($this->filePath()));
    }

}
