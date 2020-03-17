<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\FeedbackResult;
use App\Release;
use Illuminate\Http\Request;

class FeedbackController extends Controller{

    public function show(Request $request, $slug){
        $feedback = Feedback::with('related', 'release')->where('slug', $slug)->firstOrFail();
        if($request->post() && $slug){
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email',
                'comment' => 'required|string',
                'rates' => 'required|array'
            ]);
            $result = new FeedbackResult();
            $result->fill($request->post());
            $result->feedback_id = $feedback->id;
            $result->sendFeedback($feedback);
            return $result->save() ?
                redirect()->route('feedback.end', $slug) :
                redirect()->back()->withErrors(['!!!']);

        }
        return view('feedback.show', [
            'feedback' => $feedback
        ]);
    }

    public function end($slug){
        return view('feedback.end', [
            'feedback' => Feedback::with('release')->where('slug', $slug)->firstOrFail()
        ]);
    }

}
