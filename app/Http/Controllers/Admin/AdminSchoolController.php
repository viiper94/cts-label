<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SchoolCourse;
use App\SchoolTeacher;
use Illuminate\Http\Request;

class AdminSchoolController extends Controller{

    public function index(Request $request){
        return view('admin.school.index', [
            'teachers_list' => SchoolTeacher::where('category', 'teachers')->orderBy('sort_id', 'desc')->get()->sortBy('lang')->groupBy('lang'),
            'courses_list' => SchoolCourse::where('category', 'courses')->orderBy('sort_id', 'desc')->get()->sortBy('lang')->groupBy('lang'),
        ]);
    }

    public function edit(Request $request, $id){
        if($request->post() && $id){
            $this->validate($request, [
                'name' => 'string|required',
                'course_alt' => 'string|nullable',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
            ]);
            $course = SchoolCourse::findOrFail($id);
            $course->fill($request->post());
            $course->category = 'courses';
            $course->visible = $request->input('visible') == 'on';
            if($request->hasFile('image')){
                // delete old image
                $path = public_path('images/school/courses/').$course->image;
                if(file_exists($path) && is_file($path)){
                    unlink($path);
                }
                // upload new image
                $image = $request->file('image');
                $course->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/school/courses'), $course->image);
            }
            return $course->save() ?
                redirect()->route('school_admin')->with(['success' => 'Услуга успешно отредактирована!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return view('admin.school.edit', [
                'course' => SchoolCourse::findOrFail($id)
            ]);
        }
    }

}
