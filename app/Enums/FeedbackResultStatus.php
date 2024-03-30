<?php

namespace App\Enums;

enum FeedbackResultStatus :int{

    case NEW = 0;
    case ACCEPTED = 1;
    case REJECTED = 2;

    public function name() :string{
        return match ($this){
            self::NEW => trans('feedback.status.new'),
            self::ACCEPTED => trans('feedback.status.accepted'),
            self::REJECTED => trans('feedback.status.rejected'),
        };
    }

    public function getStarClass(){
        return match($this){
            self::NEW => 'bi bi-star text-muted',
            self::ACCEPTED => 'bi bi-star-fill text-success',
            self::REJECTED => 'fa-solid fa-xmark text-danger'
        };
    }

}
