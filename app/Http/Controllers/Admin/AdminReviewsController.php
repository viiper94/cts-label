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

    public function edit(Request $request, $id){
        $review = Review::findOrFail($id);
        if($request->post()){
            $this->validate($request, [
                'track' => 'required|string',
                'review' => 'required_without:additional|array',
                'additional' => 'required_without:review|array',
            ]);
            $review->track = $request->input('track');
            $review->data = [
                'reviews' => $request->input('review'),
                'additional' => $request->input('additional')
            ];
            $review->visible = $request->input('visible') == 'on';
            return $review->save() ?
                redirect()->route('reviews_admin')->with(['success' => 'Ревью успешно отредактировано!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return view('admin.reviews.edit', [
            'review' => $review
        ]);
    }

    public function add(Request $request){
        $review = new Review();
        if($request->post()){
            $this->validate($request, [
                'track' => 'required|string',
                'review' => 'required_without:additional|array',
                'additional' => 'required_without:review|array',
            ]);
            $review->sort_id = intval($review->getLatestSortId(Review::class)) + 1;
            $review->track = $request->input('track');
            $review->data = [
                'reviews' => $request->input('review'),
                'additional' => $request->input('additional')
            ];
            $review->visible = $request->input('visible') == 'on';
            return $review->save() ?
                redirect()->route('reviews_admin')->with(['success' => 'Ревью успешно добавлен!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        $review->data = $review->defaultReview;
        return view('admin.reviews.edit', [
            'review' => $review
        ]);
    }

    public function delete(Request $request, $id){
        if($id){
            $review = Review::findOrFail($id);
            return $review->delete() ?
                redirect()->back()->with(['success' => 'Ревью успешно удалено!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    public function resort(Request $request){
        foreach($request->post('sort') as $id => $sort){
            $review = Review::find($id);
            $review->sort_id = $sort;
            $review->save();
        }
        return redirect()->back()->with(['success' => 'Ревью успешно отсортированы!']);
    }

    public function sortup(Request $request, $id){
        if(isset($id)){
            $review = Review::find($id);
            $up_review = Review::where('sort_id', '>', $review->sort_id)->orderBy('sort_id', 'asc')->first();
            if(!$up_review) return redirect()->back();
            return $this->swapSort($review, $up_review)  ?
                redirect()->back()->with(['success' => 'Ревью успешно отредактировано!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    public function sortdown(Request $request, $id){
        if(isset($id)){
            $review = Review::find($id);
            $down_review = Review::where('sort_id', '<', $review->sort_id)->orderBy('sort_id', 'desc')->first();
            if(!$down_review) return redirect()->back();
            return $this->swapSort($review, $down_review) ?
                redirect()->back()->with(['success' => 'Ревью успешно отредактировано!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    private function swapSort($review, $slave_review){
        $tmp = $review->sort_id;
        $review->sort_id = $slave_review->sort_id;
        $slave_review->sort_id = $tmp;
        return $review->save() && $slave_review->save();
    }

    public function searchReviewer(Request $request){
        if($request->ajax() && $request->post('query')){
            $response = array();
            $reviews = Review::where('data', 'like', '%'.$request->post('query').'%')->get();
            if($reviews){
                foreach($reviews as $key => $item){
                    foreach($item->data['reviews'] as $review){
                        // search where query is like author
                        if(stripos($review['author'], $request->post('query')) !== false){
                            // check if already founded before
                            if(!$response){
                                $response[] = $review;
                                continue;
                            }
                            foreach($response as $author){
                                if(trim($review['location']) === trim($author['location'])){
                                    break;
                                }
                               $response[] = $review;
                            }
                        }
                    }
                }
                $status = 'ok';
            }else{
                $status = 'No result';
            }

            return response()->json([
                'data' => $response,
                'status' => $status,
            ]);
        }else{
            abort(404);
            return false;
        }
    }

}
