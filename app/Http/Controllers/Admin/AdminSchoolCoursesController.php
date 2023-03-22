<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SchoolCourse;
use Illuminate\Http\Request;

class AdminSchoolCoursesController extends Controller{

    public function index(){
        return view('admin.school.courses', [
            'courses_lang' => SchoolCourse::where('category', 'courses')->orderBy('lang')->orderBy('sort_id')->get()->groupBy('lang'),
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'string|required',
            'course_alt' => 'string|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
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

    public function update(Request $request, SchoolCourse $course){
        $this->validate($request, [
            'name' => 'string|required',
            'course_alt' => 'string|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
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
        return response()->json();
    }

}
