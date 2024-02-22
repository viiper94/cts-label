<?php

namespace App\Http\Controllers;

use App\Track;

class ReviewsController extends Controller{

    public function index(){
        return view('reviews', [
            'tracks' => Track::with([
                'reviews' => function($q){
                    $q->orderBy('sort_id');
                },
                'also_supported' => function($q){
                    $q->orderBy('sort_id');
                }])
                ->has('reviews')
                ->where('show_reviews', 1)
                ->orderBy('isrc', 'desc')
                ->paginate(2)
                ->onEachSide(1)
        ]);
    }

}
