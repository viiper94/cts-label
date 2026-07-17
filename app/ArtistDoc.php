<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ArtistDoc extends Model
{

    protected $table = 'documents';
    
    public function tracks(){
        return $this->belongsToMany('App\Track', 'tracks_docs', 'doc_id', 'track_id');
    }

    public function saveFile(UploadedFile $file){
        $name = Str::slug(explode('.', $file->getClientOriginalName())[0]).'_'.time();
        $filename = $name.'.'.$file->getClientOriginalExtension();
        $file->move(public_path('docs'), $filename);

        return $filename;
    }

    public function deleteFiles($file){
        $path = public_path('docs/'.$file);
        if(file_exists($path)){
            unlink($path);
        }
    }

}
