<?php

namespace App\Enums;

enum UserStatus :int{

    case ADMIN = 0;
    case USER = 1;
    case STUDENT = 2;
    case GRADUATE = 3;

    public function name() :string{
        return match ($this){
            self::ADMIN => 'Администратор',
            self::USER => 'Пользователь',
            self::STUDENT => 'Студент',
            self::GRADUATE => 'Выпускник',
        };
    }

    public function badgeClass() :string{
        return match ($this){
            self::ADMIN => 'text-bg-danger',
            self::USER => 'text-bg-secondary',
            self::STUDENT => 'text-bg-primary',
            self::GRADUATE => 'text-bg-success',
        };
    }

}
