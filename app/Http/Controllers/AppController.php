<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller{

    public function about(){
        return view('about');
    }

    public function ctschool(){
        return view('ctschool');
    }

    public function studio(){
        return view('studio');
    }

}
