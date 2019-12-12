<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Review;
use Illuminate\Http\Request;

class AdminReviewsController extends Controller{

    public function index(Request $request){
        $reviews = Review::orderBy('sort_id', 'desc');
        if($request->input('q')) $reviews->where('track', 'like', '%'.$request->input('q').'%');
        return view('admin.reviews.index', [
            'reviews' => $reviews->paginate(30)
        ]);
    }

}
