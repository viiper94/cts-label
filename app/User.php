<?php

namespace App;

use App\Enums\UserStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable{

    use \OwenIt\Auditing\Auditable;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => UserStatus::class,
    ];

    public function cv(){
        return $this->hasOne('App\Cv');
    }

    public function isAdmin(){
        return $this->is_admin && $this->status === 0;
    }

}
