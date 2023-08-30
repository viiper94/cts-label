<?php

namespace App\Enums;

enum CvStatus :int{

    case NEW = 0;
    case PENDING = 1;
    case DONE = 2;

    public function name() :string{
        return match ($this){
            self::NEW => trans('cv.new'),
            self::PENDING => trans('cv.pending'),
            self::DONE => trans('cv.done'),
        };
    }

    public function badgeClass() :string{
        return match ($this){
            self::NEW => 'text-bg-danger',
            self::PENDING => 'text-bg-warning',
            self::DONE => 'text-bg-success',
        };
    }

}
