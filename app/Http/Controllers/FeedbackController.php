<?php

namespace App\Http\Controllers;

use App\Release;
use Illuminate\Http\Request;

class FeedbackController extends Controller{

    public function show($release_id){
        return view('feedback.show', [
            'release' => Release::with('feedback.related')->findOrFail($release_id)
        ]);
    }

    public function end($release_id){
        return view('feedback.end', [
            'release' => Release::with('feedback')->findOrFail($release_id)
        ]);
    }

}
