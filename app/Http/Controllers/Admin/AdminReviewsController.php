<?php

namespace App\Http\Controllers\Admin;

use App\Enums\FeedbackResultStatus;
use App\FeedbackResult;
use App\Http\Controllers\Controller;
use App\Review;
use App\Track;
use Illuminate\Http\Request;

class AdminReviewsController extends Controller{

    public function show(Request $request, $id){
        if(!$request->ajax()) abort(403);
        $track = Track::with([
            'reviews' => function($q){
                $q->orderBy('sort_id');
            },
            'also_supported' => function($q){
                $q->orderBy('sort_id');
            }])->find($id);
        return response()->json([
            'html' => view('admin.reviews.track_reviews', [
                'track' => $track
            ])->render(),
            'name' => $track->getFullTitle()
        ]);
    }

    public function create(Request $request){
        if(!$request->ajax()) abort(403);
        $review = new Review();
        return response()->json([
            'html' => view('admin.reviews.edit', compact('review'))->render()
        ]);
    }

    public function store(Request $request){
        if(!$request->ajax()) abort(403);
        $this->validate($request, [
            'track_id' => 'required|string',
            'author' => 'nullable|string|max:191',
            'location' => 'nullable|string|max:191',
            'source' => 'nullable|string|max:191',
            'review' => 'nullable|required_with:score|string',
            'score' => 'nullable|required_with:review|numeric',
            'result_accept' => 'nullable|numeric',
        ]);
        $review = new Review();
        $review->fill($request->post()+[
            'sort_id' => 0
            ]);
        if($review->save()){
            if($request->post('result_accept')){
                $result = FeedbackResult::find($request->post('result_accept'));
                $result->status = FeedbackResultStatus::ACCEPTED;
                $result->save();
            }
            return response()->json([
                'message' => trans('reviews.added_successfully'),
                'url' => route('reviews.show', $review->track_id)
            ]);
        }
        return response()->json([
                'message' => trans('alert.error'),
            ], status:500);
    }

    public function edit(Request $request, Review $review){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.reviews.edit', compact('review'))->render()
        ]);
    }

    public function update(Request $request, Review $review){
        if(!$request->ajax()) abort(403);
        $this->validate($request, [
            'track_id' => 'required|string',
            'author' => 'nullable|string|max:191',
            'location' => 'nullable|string|max:191',
            'source' => 'nullable|string|max:191',
            'review' => 'nullable|required_with:score|string',
            'score' => 'nullable|required_with:review|numeric',
        ]);
        $review->fill($request->post()+[
                'sort_id' => 0
            ]);
        return $review->save() ?
            response()->json([
                'message' => trans('reviews.edited_successfully'),
                'url' => route('reviews.show', $review->track_id)
            ]) :
            response()->json([
                'message' => trans('alert.error'),
            ], status:500);
    }

    public function destroy(Request $request, Review $review){
        if(!$request->ajax()) abort(403);
        return $review->delete() ?
            response()->json([
                'message' => 'Ревью удалено!',
                'url' => route('reviews.show', $review->track_id)
            ]) :
            response()->json(status:500);
    }

    public function search(Request $request){
        if(!$request->ajax() && $request->post('query')) abort(403);
        $reviews = Review::searchAuthorLocation($request->post('query'));
        return response()->json([
            'html' => view('admin.reviews.author_locations', compact('reviews'))->render(),
        ]);
    }

    public function resort(Request $request){
        if(!$request->ajax()) abort(403);
        foreach($request->post('data') as $key => $id){
            $review = Review::find($id);
            $review->sort_id = $key;
            $review->save();
        }
        return response()->json([
            'message' => trans('shared.admin.sorted')
        ]);
    }

}
