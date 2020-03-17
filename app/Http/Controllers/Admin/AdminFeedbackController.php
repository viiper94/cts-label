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
            'feedback_list' => $feedback->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    public function edit(Request $request, $slug){
        $feedback = Feedback::with('release', 'related', 'results')->where('slug', $slug)->firstOrFail();
        if($request->post() && $slug){
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
        return view('admin.feedback.edit', [
            'feedback' => $feedback,
            'feedback_list' => Feedback::orderBy('id', 'desc')->get()
        ]);
    }

    public function add(Request $request, $id = null){
        $feedback = new Feedback();
        if($id){
            // if feedback for existing release
            $release = Release::find($id);
            $feedback->release_id = $release->id;
            $feedback->feedback_title = $release->title;
        }
        $feedback->tracks = [0 => ['title' => '', 96 => '', 320 => '']];
        if($request->post()){
            $this->validate($request, [
                'feedback_title' => 'string|required',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png|nullable',
                'tracks' => 'array|required'
            ]);
            $feedback->feedback_title = $request->input('feedback_title');
            $feedback->slug = Str::slug($feedback->feedback_title);
            $feedback->sort_id = $feedback->getLatestSortId(Feedback::class);
            $feedback->visible = $request->input('visible') == 'on';
            $feedback->tracks = $feedback->saveTracks($request);
            $feedback->archive_name = $feedback->archiveTracks();
            if(!$id && $request->hasFile('image')){
                $image = $request->file('image');
                $feedback->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/feedback'), $feedback->image);
            }
            return $feedback->save() ?
                redirect()->route('feedback_admin')->with(['success' => 'Фидбэк успешно добавлен!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        if($id){
            $feedback->release = $release;
        }
        return view('admin.feedback.edit', [
            'feedback' => $feedback,
            'feedback_list' => Feedback::orderBy('id', 'desc')->get()
        ]);
    }

    public function delete(Request $request, $slug){
        if($slug){
            $feedback = Feedback::where('slug', $slug)->firstOrFail();
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
        }else{
            return abort(404);
        }
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
