<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SchoolCourse;
use Illuminate\Http\Request;

class AdminSchoolCoursesController extends Controller{

    public function index(){
        return view('admin.school.courses.index', [
            'courses_lang' => SchoolCourse::where('category', 'courses')
                ->orderBy('lang')
                ->orderBy('sort_id')
                ->get()
                ->groupBy('lang'),
        ]);
    }

    public function create(Request $request){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.school.courses.edit', ['course' => new SchoolCourse()])->render()
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'string|required',
            'course_alt' => 'string|nullable',
            'image' => 'nullable|image|mimes:jpeg,png'
        ]);
        $course = new SchoolCourse();
        $course->fill($request->post());
        $course->category = 'courses';
        if($request->hasFile('image')){
            $course->saveImage($request->file('image'));
        }
        return $course->save() ?
            redirect()->route('school.courses.index')->with(['success' => 'Услуга успешно отредактирована!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function edit(Request $request, SchoolCourse $course){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.school.courses.edit', compact('course'))->render()
        ]);
    }

    public function update(Request $request, SchoolCourse $course){
        $this->validate($request, [
            'name' => 'string|required',
            'course_alt' => 'string|nullable',
            'image' => 'nullable|image|mimes:jpeg,png'
        ]);
        $course->fill($request->post());
        $course->category = 'courses';
        if($request->hasFile('image')){
            $course->deleteImages();
            $course->saveImage($request->file('image'));
        }
        return $course->save() ?
            redirect()->route('school.courses.index')->with(['success' => 'Услуга успешно отредактирована!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(SchoolCourse $course){
        $course->deleteImages();
        return $course->delete() ?
            redirect()->back()->with(['success' => 'Успешно удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function resort(Request $request){
        if(!$request->ajax()) abort(404);
        foreach($request->post('data') as $sort => $id){
            SchoolCourse::find($id)->update(['sort_id' => $sort]);
        }
        return response()->json([
            'status' => trans('shared.admin.sorted')
        ]);
    }

}
