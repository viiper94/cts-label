<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class StudioService extends SharedModel{

    protected $table = 'studio';

    protected $casts = [
        'visible' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'service_alt',
        'lang',
        'sort_id',
        'visible'
    ];

    public function saveImage(UploadedFile $image){
        $name = md5($image->getClientOriginalName().time());
        $this->image = $name.'.jpg';
        $this->image_webp = $name.'.webp';
        $file = Image::load($image->getPathname())->width(185)->quality(75);
        $file->format(Manipulations::FORMAT_WEBP)->save(public_path('images/studio/services/').$this->image_webp);
        $file->format(Manipulations::FORMAT_JPG)->save(public_path('images/studio/services/').$this->image);
    }

    public function deleteImages(){
        foreach([$this->image ?? null, $this->image_webp ?? null] as $src){
            $path = public_path('images/studio/services/').$src;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
        }
    }

}
