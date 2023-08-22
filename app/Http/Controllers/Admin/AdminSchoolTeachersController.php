<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SchoolTeacher;
use Illuminate\Http\Request;

class AdminSchoolTeachersController extends Controller{

    public function index(){
        return view('admin.school.teachers.index', [
            'teachers_lang' => SchoolTeacher::where('category', 'teachers')
                ->orderBy('lang')
                ->orderBy('sort_id')
                ->get()
                ->groupBy('lang'),
        ]);
    }

    public function create(Request $request){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.school.teachers.edit', ['teacher' => new SchoolTeacher()])->render()
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'string|required',
            'course_alt' => 'string|nullable',
            'teacher_binfo' => 'string|nullable',
            'teacher_hinfo' => 'string|nullable',
            'image' => 'nullable|image|mimes:jpeg,png'
        ]);
        $teacher = new SchoolTeacher();
        $teacher->fill($request->post());
        $teacher->category = 'teachers';
        if($request->hasFile('image')){
            $teacher->saveImage($request->file('image'));
        }
        return $teacher->save() ?
            redirect()->route('school.teachers.index')->with(['success' => 'Учитель успешно отредактирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function edit(Request $request, SchoolTeacher $teacher){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.school.teachers.edit', ['teacher' => $teacher])->render()
        ]);
    }

    public function update(Request $request, SchoolTeacher $teacher){
        $this->validate($request, [
            'name' => 'string|required',
            'course_alt' => 'string|nullable',
            'teacher_binfo' => 'string|nullable',
            'teacher_hinfo' => 'string|nullable',
            'image' => 'nullable|image|mimes:jpeg,png'
        ]);
        $teacher->fill($request->post());
        $teacher->category = 'teachers';
        if($request->hasFile('image')){
            $teacher->deleteImages();
            $teacher->saveImage($request->file('image'));
        }
        return $teacher->save() ?
            redirect()->route('school.teachers.index')->with(['success' => 'Учитель успешно отредактирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(SchoolTeacher $teacher){
        $teacher->deleteImages();
        return $teacher->delete() ?
            redirect()->back()->with(['success' => 'Успешно удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function resort(Request $request){
        if(!$request->ajax()) abort(404);
        foreach($request->post('data') as $sort => $id){
            SchoolTeacher::find($id)->update(['sort_id' => $sort]);
        }
        return response()->json([
            'status' => trans('shared.admin.sorted')
        ]);
    }

}
