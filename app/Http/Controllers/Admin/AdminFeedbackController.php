<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\Http\Controllers\Controller;
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
        return view('admin.feedback.edit', [
            'feedback' => Feedback::with('release')->where('release_id', $id)->firstOrFail(),
            'feedback_list' => Feedback::orderBy('id', 'desc')->get()
        ]);
    }

}
