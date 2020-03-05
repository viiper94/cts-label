<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\Http\Controllers\Controller;
use App\Release;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller{

    public function index(Request $request){
        return view('admin.feedback.index', [
            'feedback_list' => Feedback::with('release')->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    public function edit(Request $request, $id){
        if($request->post() && $id){
            $this->validate($request, [
                'feedback_title' => 'string|required',
                'tracks' => 'array|required'
            ]);
            $feedback = Feedback::where('release_id', $id)->firstOrFail();
            $feedback->fill($request->post());
            $feedback->visible = $request->input('visible') == 'on';
            $feedback->tracks = $feedback->saveTracks($request);
            $feedback->archive_name = $feedback->archiveTracks($request);
            return $feedback->save() ?
                redirect()->route('feedback_admin')->with(['success' => 'Фидбэк успешно отредактирован!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        $release = Release::with('feedback')->find($id);
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
            $release->feedback->fill($request->post());
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

}
