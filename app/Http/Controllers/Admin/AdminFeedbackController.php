<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\FeedbackResult;
use App\Http\Controllers\Controller;
use App\Release;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller{

    public function index(Request $request){
        $feedback = Feedback::with('release', 'results');
        if($request->input('q')) $feedback->where('feedback_title', 'like', '%'.$request->input('q').'%');
        return view('admin.feedback.index', [
            'feedback_list' => $feedback->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    public function edit(Request $request, $id){
        $release = Release::with('feedback.related', 'feedback.results')->find($id);
        if($request->post() && $id){
            $this->validate($request, [
                'feedback_title' => 'string|required',
                'tracks' => 'array|required'
            ]);
            $release->feedback->feedback_title = $request->input('feedback_title');
            $release->feedback->visible = $request->input('visible') == 'on';
            $release->feedback->tracks = $release->feedback->saveTracks($request);
            $release->feedback->archive_name = $release->feedback->archiveTracks($request);
            $release->feedback->renewRelatedFeedback($request->post('related'));
            return $release->feedback->save() ?
                redirect()->route('feedback_admin')->with(['success' => 'Фидбэк успешно отредактирован!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return view('admin.feedback.edit', [
            'release' => $release,
            'feedback_list' => Feedback::orderBy('id', 'desc')->get()
        ]);
    }

    public function add(Request $request, $id){
        $release = Release::find($id);
        $release->feedback = new Feedback();
        $release->feedback->release_id = $id;
        $release->feedback->tracks = [0 => ['title' => '', 96 => '', 320 => '']];
        if($request->post() && $id){
            $this->validate($request, [
                'feedback_title' => 'string|required',
                'tracks' => 'array|required'
            ]);
            $release->feedback->feedback_title = $request->input('feedback_title');
            $release->feedback->sort_id = $release->feedback->getLatestSortId(Feedback::class);
            $release->feedback->visible = $request->input('visible') == 'on';
            $release->feedback->tracks = $release->feedback->saveTracks($request);
            $release->feedback->archive_name = $release->feedback->archiveTracks();
            return $release->feedback->save() ?
                redirect()->route('feedback_admin')->with(['success' => 'Фидбэк успешно добавлен!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        $release->feedback->feedback_title = $release->title;
        return view('admin.feedback.edit', [
            'release' => $release,
            'feedback_list' => Feedback::orderBy('id', 'desc')->get()
        ]);
    }

    public function delete(Request $request, $id){
        if($id){
            $feedback = Feedback::where('release_id', $id)->firstOrFail();
            $feedback->related()->detach();
            if($feedback->tracks){
                // delete audio files
                $path = public_path('audio/feedback/'.$feedback->release_id);
                if(is_dir($path)){
                    $this->rrmdir($path);
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
