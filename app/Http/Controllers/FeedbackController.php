<?php

namespace App\Http\Controllers;

use App\FeedbackResult;
use App\Release;
use Illuminate\Http\Request;

class FeedbackController extends Controller{

    public function show(Request $request, $release_id){
        $release = Release::with('feedback.related')->findOrFail($release_id);
        if($request->post() && $release_id){
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email',
                'comment' => 'required|string',
                'rates' => 'required|array'
            ]);
            $result = new FeedbackResult();
            $result->fill($request->post());
            $result->feedback_rid = $release_id;
            $result->sendFeedback($release->feedback);
            return $result->save() ?
                redirect()->route('feedback.end', $release_id) :
                redirect()->back()->withErrors(['!!!']);

        }
        return view('feedback.show', [
            'release' => $release
        ]);
    }

    public function end($release_id){
        return view('feedback.end', [
            'release' => Release::with('feedback')->findOrFail($release_id)
        ]);
    }

}
