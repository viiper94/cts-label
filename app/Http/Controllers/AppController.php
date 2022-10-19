<?php

namespace App\Http\Controllers;

use App\School;
use App\StudioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AppController extends Controller{

    public function about(){
        return view('about');
    }

    public function ctschool(){
        return view('school', [
            'teachers' => School::where(['category' => 'teachers', 'lang' => App::getLocale()])->orderBy('sort_id', 'desc')->get(),
            'courses' => School::where(['category' => 'courses', 'lang' => App::getLocale()])->orderBy('sort_id', 'desc')->get(),
            'prices' => [],
            'subject' => [],
        ]);
    }

    public function studio(){
        return view('studio', [
            'services' => StudioService::where(['visible' => 1, 'lang' => App::getLocale()])->orderBy('sort_id')->get()
        ]);
    }

}
