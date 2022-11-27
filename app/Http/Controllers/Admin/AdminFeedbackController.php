<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\FeedbackResult;
use App\Http\Controllers\Controller;
use App\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminFeedbackController extends Controller{

    public function index(Request $request){
        $feedback = Feedback::with('release', 'results');
        if($request->input('q')) $feedback->where('feedback_title', 'like', '%'.$request->input('q').'%');
        return view('admin.feedback.index', [
            'feedback_list' => $feedback->latest()->paginate(20),
            'releases_without_feedback' => Release::with('feedback')->doesntHave('feedback')
                ->orderBy('sort_id', 'desc')->get()
        ]);
    }

    public function create(Release $release = null){
        $feedback = new Feedback();
        if($release){
            $feedback->release_id = $release->id;
            $feedback->feedback_title = $release->title;
            $feedback->release = $release;
        }
        $tracks_count = $release ? $feedback->release->getTracksCount() : 1;
        $tracks = array();
        for($i = 0; $i < $tracks_count; $i++){
            $tracks[$i] = ['title' => '', 96 => '', 320 => ''];
        }
        $feedback->tracks = $tracks;
        return view('admin.feedback.edit', [
            'feedback' => $feedback,
            'feedback_list' => Feedback::orderBy('release_id', 'desc')->get()
        ]);
    }

    public function store(Request $request, Release $release = null){
        $feedback = new Feedback();
        $this->validate($request, [
            'feedback_title' => 'string|required',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png|nullable',
            'tracks' => 'array|required'
        ]);
        $feedback->release_id = $release?->id;
        $feedback->feedback_title = $request->input('feedback_title');
        $feedback->slug = Str::slug($feedback->feedback_title);
        $feedback->sort_id = $feedback->getLatestSortId(Feedback::class);
        $feedback->visible = $request->input('visible') == 'on';
        $feedback->tracks = $feedback->saveTracks($request);
        $feedback->archive_name = $feedback->archiveTracks();
        if(!$release && $request->hasFile('image')){
            $image = $request->file('image');
            $feedback->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/feedback'), $feedback->image);
        }
        return $feedback->save() ?
            redirect()->route('feedback.index')->with(['success' => 'Фидбэк успешно добавлен!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function edit(Feedback $feedback){
        $feedback->load('related');
        return view('admin.feedback.edit', [
            'feedback' => $feedback,
            'feedback_list' => Feedback::orderBy('release_id', 'desc')->get()
        ]);
    }

    public function update(Request $request, Feedback $feedback){
        $this->validate($request, [
            'feedback_title' => 'string|required',
            'tracks' => 'array|required'
        ]);
        $feedback->feedback_title = $request->input('feedback_title');
        $feedback->visible = $request->input('visible') == 'on';
        $feedback->tracks = $feedback->saveTracks($request);
        $feedback->archive_name = $feedback->archiveTracks($request);
        $feedback->renewRelatedFeedback($request->post('related'));
        if($request->hasFile('image')){
            // delete old image
            $path = public_path('images/feedback/').$feedback->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
            // upload new image
            $image = $request->file('image');
            $feedback->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/feedback'), $feedback->image);
        }
        return $feedback->save() ?
            redirect()->route('feedback_admin')->with(['success' => 'Фидбэк успешно отредактирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(Feedback $feedback){
        $feedback->related()->detach();
        if($feedback->tracks){
            // delete audio files
            $path = public_path('audio/feedback/'.$feedback->slug);
            if(is_dir($path)){
                $this->rrmdir($path);
            }
            if($feedback->image && is_file(public_path('images/feedback/'.$feedback->image))){
                unlink(public_path('images/feedback/'.$feedback->image));
            }
        }
        return $feedback->delete() ?
            redirect()->back()->with(['success' => 'Фидбэк успешно удалён!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function removeResult(Request $request, $id){
        if($id){
            return FeedbackResult::find($id)->delete() ?
                redirect()->back()->with(['success' => 'Успешно удалёно!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

}
