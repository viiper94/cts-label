<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\FeedbackResult;
use App\Mail\CvMail;
use App\Mail\FeedbackMail;
use App\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller{

    public function show(Request $request, $slug){
        $feedback = Feedback::with('related', 'release', 'ftracks')->where('slug', $slug)->firstOrFail();
        if($request->post() && $slug){
            $this->validate($request, [
                'name' => 'required|max:191|string',
                'email' => 'required|email|max:191',
                'comment' => 'required|string',
                'rates' => 'required|array'
            ]);
            $result = new FeedbackResult();
            $result->fill($request->post());
            $result->feedback_id = $feedback->id;
            Mail::to(env('ADMIN_EMAIL'))->send(new FeedbackMail($feedback, $result));
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
            'feedback' => Feedback::with('related', 'ftracks')->where('slug', $slug)->firstOrFail()
        ]);
    }

    public function getTracks(Request $request, $slug){
        if(!$request->ajax()) abort(404);
        $feedback = Feedback::with('ftracks')->where('slug', $slug)->firstOrFail();
        $tracks = array();
        foreach($feedback->ftracks as $key => $track){
            $tracks[$key] = [
                'trackIndex' => $key,
                'url' => $track->filePath(true),
                'trackId' => $track->id,
                'feedbackId' => $feedback->id,
            ];
            $tracks[$key] += isset($track->peaks) && !empty(json_decode($track->peaks))
                ? ['peaks' => json_decode(Feedback::getPeaks($track))]
                : ['savePeaksRoute' => route('feedback.peaks')];
        }
        return response()->json([
            'tracks' => $tracks
        ]);
    }

}
