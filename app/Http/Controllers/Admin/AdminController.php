<?php

namespace App\Http\Controllers\Admin;

use App\Artist;
use App\Feedback;
use App\Http\Controllers\Controller;
use App\Release;
use Illuminate\Http\Request;

class AdminController extends Controller{

    public function index(){
        return redirect()->route('releases.index');
    }

}
