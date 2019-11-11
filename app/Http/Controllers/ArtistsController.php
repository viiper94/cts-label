<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtistsController extends Controller{

    public function index(Request $request){
        return view('artists', [
            'artists' => Artist::where('visible', 1)->orderBy('name', 'asc')->paginate(28)->onEachSide(1)
        ]);
    }

}
