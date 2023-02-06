<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class School extends SharedModel{

    protected $table = 'school';
    protected $casts = [
        'visible' => 'boolean'
    ];

    public function saveImage(UploadedFile $image){
        $name = md5($image->getClientOriginalName().time());
        $format = $this->category === 'teachers' ? Manipulations::FORMAT_PNG : Manipulations::FORMAT_JPG;
        $this->image = $name.'.'.$format;
        $this->image_webp = $name.'.webp';
        $file = Image::load($image->getPathname())->quality(75)->width($this->category === 'teachers' ? 84 : 185);
        $file->format(Manipulations::FORMAT_WEBP)->save(public_path('images/school/'.$this->category.'/').$this->image_webp);
        $file->format($format)->save(public_path('images/school/'.$this->category.'/').$this->image);
    }

    public function deleteImages(){
        foreach([$this->image ?? null, $this->image_webp ?? null] as $src){
            $path = public_path('images/school/'.$this->category.'/').$src;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
        }
    }

}
