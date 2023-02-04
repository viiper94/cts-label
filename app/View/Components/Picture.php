<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Picture extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.picture');
    }

    public function type($src) :string|bool{
        $file = array_reverse(explode('/', $src))[0];
        $format = array_reverse(explode('.', $file))[0];
        if(!$format) return false;
        return match($format){
            'avif' => 'image/avif',
            'bmp' => 'image/bmp',
            'gif' => 'image/gif',
            'jpeg', 'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'svg' => 'image/svg+xml',
            'tiff', 'tif' => 'image/tiff',
            'webp' => 'image/webp',
        };
    }

    public function hasFile($src) :bool{
        return is_file(public_path($src));
    }

}
