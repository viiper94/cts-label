<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Review;
use App\Review0;
use Illuminate\Http\Request;

class ReviewsController extends Controller{

    public function index(Request $request){
        return view('reviews', [
            'tracks' => Review::where('visible', 1)->orderBy('sort_id', 'desc')->paginate(2)->onEachSide(1)
        ]);
    }

}
