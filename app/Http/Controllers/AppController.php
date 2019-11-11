<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller{

    public function about(){
        return view('about');
    }

    public function ctschool(){
        return view('school');
    }

    public function studio(){
        return view('studio',[
            'services' => [],
            'subject' => [],
        ]);
    }

}
