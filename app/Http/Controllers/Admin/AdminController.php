<?php

namespace App\Http\Controllers\Admin;

use App\Artist;
use App\Http\Controllers\Controller;
use App\Release;
use Illuminate\Http\Request;

class AdminController extends Controller{

    public function index(){
        return view('admin.index', [
            'releases' => Release::orderBy('sort_id', 'desc')->take(15)->get(),
            'artists' => Artist::orderBy('sort_id', 'desc')->take(15)->get(),
            'reviews' => [],
            'feedback' => [],
            'users' => []
        ]);
    }

}
