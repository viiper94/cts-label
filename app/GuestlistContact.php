<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestlistContact extends Model{

    protected $table = 'guestlist';

    protected $fillable = [
        'name', 'email', 'company'
    ];

}
