<?php

namespace App\Http\Controllers\Admin;

use App\Enums\FeedbackResultStatus;
use App\FeedbackResult;
use App\FeedbackTrack;
use App\Http\Controllers\Controller;
use App\Release;
use App\Review;
use App\Track;
use Illuminate\Http\Request;

class AdminFeedbackResultController extends Controller{

    public function add(Request $request, FeedbackResult $result){
        if(!$request->ajax()) abort(404);
        $track = $this->getTrack($result);
        $release = $this->getRelease($result);
        return response()->json([
            'df' => Review::searchAuthorLocation(trim($result->name)),
            'html' => view('admin.feedback.add_review', [
                'result' => $result,
                'track' => $track,
                'release' => $release,
                'author' => $result->name,
                'comment' => $result->comment,
                'score' => $result->getBestTrackScore() / 2,
                'locations' => Review::searchAuthorLocation(trim($result->name))
            ])->render()
        ]);
    }

    public function modify(Request $request, FeedbackResult $result){
        if(!$request->ajax()) abort(404);
        $this->validate($request, [
            'action' => 'required|numeric'
        ]);
        $result->status = $request->post('action');
        if($result->save()){
            return response()->json([
                'message' => trans('alert.success')
            ]);
        }
        return response()->json([
            'message' => trans('alert.error')
        ], 500);
    }

    public function destroy(Request $request, FeedbackResult $result){

    }

    private function getTrack(FeedbackResult $result) :Track|bool{

        if($result->best_track){
            $ftrack = FeedbackTrack::with('track.releases')
                ->where('name', $result->best_track)->first();
        }else{
            $ftrack = FeedbackTrack::with('track.releases')
                ->where('feedback_id', $result->feedback_id)->first();
        }

        if($ftrack->track){
            return $ftrack->track;
        }else{
            $pattern = '/^(?<artist>[^-]*)(?: - )(?<title>.+?)(?: \((?<mix>.+?)\))?$/';
            if(preg_match($pattern, $ftrack->name, $matches)){
                $query = Track::where('artists', 'like', '%' . $matches['artist'] . '%')
                    ->where('name', 'like', '%' . $matches['title'] . '%');
                if(isset($matches['mix'])) $query = $query->where('mix_name', 'like', '%' . $matches['mix'] . '%');
                return $query->first();
            }
        }
        return false;
    }

    private function getRelease(FeedbackResult $result) :Release|bool{
        $result->load('feedback.release.tracks');
        if($result->feedback->release) return $result->feedback->release;
        return false;
    }

}
