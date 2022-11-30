<?php

namespace App\Http\Controllers\Admin;

use App\Cv;
use App\Http\Controllers\Controller;

class AdminCvController extends Controller{

    public function index(){
        return view('admin.cv.index', [
            'cv_list' => Cv::with('user')->get()
        ]);
    }

    public function show(Cv $cv){
        $cv->update([
            'status' => 1
        ]);
        return view('admin.cv.edit', compact('cv'));
    }

    public function destroy(Cv $cv){
        return $cv->delete() ?
            redirect()->back()->with(['success' => 'Анкета удалена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

}
