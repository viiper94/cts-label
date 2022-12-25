<?php

namespace App\Http\Controllers\Admin;

use App\Cv;
use App\Http\Controllers\Controller;

class AdminSchoolCvController extends Controller{

    public function index(){
        return view('admin.school.cv.index', [
            'cv_list' => Cv::with('user')->get()
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
            redirect()->route('school.cv.index')->with(['success' => 'Анкета удалена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function document(Cv $cv){
        $cv->document = $cv->createDocument();
        return $cv->save() ?
            redirect()->back()->with(['success' => 'Файл сгенерирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

}
