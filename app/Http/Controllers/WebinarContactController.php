<?php

namespace App\Http\Controllers;

use App\WebinarContact;
use Illuminate\Http\Request;

class WebinarContactController extends Controller{

    public function index(){
        return view('event.index');
    }

}
