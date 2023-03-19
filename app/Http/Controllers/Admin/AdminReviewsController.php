<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Review;
use App\Track;
use Illuminate\Http\Request;

class AdminReviewsController extends Controller{

    public function index(Request $request){
        $reviews = Review::orderBy('sort_id', 'desc');
        if($request->input('q')) $reviews->where('track', 'like', '%'.$request->input('q').'%');
        return view('admin.reviews.index', [
            'reviews' => $reviews->paginate(30)
        ]);
    }

    public function create(){
        $review = new Review();
        return view('admin.reviews.edit', compact('review'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'track' => 'required|string',
            'review' => 'required_without:additional|array',
            'additional' => 'required_without:review|array',
        ]);
        $review = new Review();
        $review->fill($request->post());
        $review->sort_id = intval($review->getLatestSortId(Review::class)) + 1;
        $review->data = [
            'reviews' => array_values($request->input('review')),
            'additional' => array_values($request->input('additional'))
        ];
        return $review->save() ?
            redirect()->route('reviews.index')->with(['success' => 'Ревью успешно добавлено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function edit(Review $review){
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review){
        $this->validate($request, [
            'track' => 'required|string',
            'review' => 'required_without:additional|array',
            'additional' => 'required_without:review|array',
        ]);
        $review->fill($request->post());
        $review->data = [
            'reviews' => array_values($request->input('review')),
            'additional' => array_values($request->input('additional'))
        ];
        return $review->save() ?
            redirect()->route('reviews.index')->with(['success' => 'Ревью успешно отредактировано!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(Review $review){
        return $review->delete() ?
            redirect()->route('reviews.index')->with(['success' => 'Ревью успешно удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function resort(Request $request){
        foreach($request->post('sort') as $id => $sort){
            $review = Review::find($id);
            $review->sort_id = $sort;
            $review->save();
        }
        return redirect()->back()->with(['success' => 'Ревью успешно отсортированы!']);
    }

    public function sort(Request $request, $id, $direction){
        if(isset($id)){
            $review = Review::find($id);
            if($direction === 'up') $next_review = Review::where('sort_id', '>', $review->sort_id)->orderBy('sort_id', 'asc')->first();
            else $next_review = Review::where('sort_id', '<', $review->sort_id)->orderBy('sort_id', 'desc')->first();
            if(!$next_review) return redirect()->back();
            return $review->swapSort($review, $next_review)  ?
                redirect()->back()->with(['success' => 'Ревью успешно отредактировано!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    public function search(Request $request){
        if($request->ajax() && $request->post('query')){
            $response = array();
            $reviews = Review::where('data', 'like', '%'.$request->post('query').'%')->get();
            if($reviews){
                foreach($reviews as $item){
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
        }
    }

    public function getTemplate(Request $request){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'html' => view('admin.reviews.'. $request->target .'_item', [
                'key' => $request->index,
                'item' => [
                    'author' => '',
                    'location' => '',
                    'review' => '',
                    'score' => ''
                ]
            ])->render()
        ]);
    }

    public function import(){
        $reviews = json_decode(file_get_contents(resource_path('reviews.json')), true);
        foreach($reviews as $review){
            $review_track_author = explode(' - ', $review['track'])[0];
            $review_track_name_and_mix = explode(' - ', $review['track'])[1];
            if(stripos($review_track_name_and_mix, ' (')){
                $review_track_name = explode(' (', $review_track_name_and_mix)[0];
                $review_track_mix =  str_replace(')', '', explode(' (', $review_track_name_and_mix)[1]);
            }else{
                $review_track_name = $review_track_name_and_mix;
                $review_track_mix = null;
            }

            $q = Track::whereName(trim($review_track_name))->whereArtists(trim($review_track_author));
            if($review_track_mix) $q = $q->whereMixName($review_track_mix);
            $track = $q->get();

            if(count($track) === 1){

                foreach($review['data']['reviews'] as $item){
                    Review::create([
                        'track_id' => $track->id,
                        'author' => $item->author,
                        'location' => $item->location,
                        'review' => $item->review,
                        'score' => $item->score,
                        'sort_id' => 0,
                    ]);
                }
                foreach($review['data']['additional'] as $item){
                    Review::create([
                        'track_id' => $track->id,
                        'author' => $item->author,
                        'location' => $item->location,
                        'sort_id' => 0,
                    ]);
                }

            }else{
                if(count($track) > 1){
                    printf("Знайдено більше одного: $review[track] / $review_track_author / $review_track_name / $review_track_mix /<br>");
                }
                if(count($track) === 0){
                    printf("Не знайдено жодного треку: $review[track] / $review_track_author / $review_track_name / $review_track_mix /<br>");
                }
            }
        }
    }

}
