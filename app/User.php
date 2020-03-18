<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $statusCodes = [
        0 => [
            'name' => 'Пользователь',
            'labelClass' => 'label-default'
        ],
        1 => [
            'name' => 'Студент',
            'labelClass' => 'label-info'
        ],
        2 => [
            'name' => 'Выпускник',
            'labelClass' => 'label-success'
        ],
    ];

    public function cv(){
        return $this->hasOne('App\Cv');
    }

    public function getStatus(){
        if($this->is_admin) return ['name' => 'Aдминистратор', 'labelClass' => 'label-danger'];
        return key_exists($this->status, $this->statusCodes) ? $this->statusCodes[$this->status] : $this->statusCodes[0];
    }

}
