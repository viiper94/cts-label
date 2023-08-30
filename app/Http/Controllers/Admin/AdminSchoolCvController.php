<?php

namespace App\Http\Controllers\Admin;

use App\Cv;
use App\Http\Controllers\Controller;

class AdminSchoolCvController extends Controller{

    public function index(){
        return view('admin.school.cv.index', [
            'cv_list' => Cv::with('user')->orderBy('status')->get()
        ]);
    }

    public function show(Cv $cv){
        $cv->update([
            'status' => 1
        ]);
        return view('admin.school.cv.edit', compact('cv'));
    }

    public function destroy(Cv $cv){
        return $cv->delete() ?
            redirect()->route('school.cv.index')->with(['success' => trans('cv.cv_deleted')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function document(Cv $cv){
        $cv->document = $cv->createDocument();
        return $cv->save() ?
            redirect()->back()->with(['success' => trans('cv.cv_generated')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

}
