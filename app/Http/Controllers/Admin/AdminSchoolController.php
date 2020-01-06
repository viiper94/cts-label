<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\School;
use App\SchoolCourse;
use App\SchoolTeacher;
use Illuminate\Http\Request;

class AdminSchoolController extends Controller{

    public function index(Request $request){
        return view('admin.school.index', [
            'teachers_list' => SchoolTeacher::where('category', 'teachers')->orderBy('sort_id', 'desc')->get()->sortBy('lang')->groupBy('lang'),
            'courses_list' => SchoolCourse::where('category', 'courses')->orderBy('sort_id', 'desc')->get()->groupBy('lang'),
        ]);
    }

    public function editCourse(Request $request, $id){
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
            return view('admin.school.edit_course', [
                'course' => SchoolCourse::findOrFail($id)
            ]);
        }
    }

    public function editTeacher(Request $request, $id){
        if($request->post() && $id){
            $this->validate($request, [
                'name' => 'string|required',
                'teacher_binfo' => 'string|required',
                'teacher_hinfo' => 'string|nullable',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
            ]);
            $course = SchoolTeacher::findOrFail($id);
            $course->fill($request->post());
            $course->category = 'teachers';
            $course->visible = $request->input('visible') == 'on';
            if($request->hasFile('image')){
                // delete old image
                $path = public_path('images/school/teachers/').$course->image;
                if(file_exists($path) && is_file($path)){
                    unlink($path);
                }
                // upload new image
                $image = $request->file('image');
                $course->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/school/teachers'), $course->image);
            }
            return $course->save() ?
                redirect()->route('school_admin')->with(['success' => 'Преподаватель успешно отредактирован!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return view('admin.school.edit_teacher', [
                'teacher' => SchoolTeacher::findOrFail($id)
            ]);
        }
    }

    public function addCourse(Request $request){
        $course = new SchoolCourse();
        if($request->post()){
            $this->validate($request, [
                'name' => 'string|required',
                'course_alt' => 'string|nullable',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
            ]);
            $course->fill($request->post());
            $course->category = 'courses';
            $course->visible = $request->input('visible') == 'on';
            if($request->hasFile('image')){
                $image = $request->file('image');
                $course->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/school/courses'), $course->image);
            }
            return $course->save() ?
                redirect()->route('school_admin')->with(['success' => 'Услуга успешно добавлена!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return view('admin.school.edit_course', [
                'course' => $course
            ]);
        }
    }

    public function delete(Request $request, $id){
        if($id){
            $item = School::find($id);
            if($item->image){
                $path = public_path('images/school/'.$item->category.'/').$item->image;
                if(file_exists($path) && is_file($path)){
                    unlink($path);
                }
            }
            return $item->delete() ?
                redirect()->back()->with(['success' => 'Успешно удалено!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    public function resort(Request $request){
        foreach($request->post('sort') as $id => $sort){
            $item = School::find($id);
            $item->sort_id = $sort;
            $item->save();
        }
        return redirect()->back()->with(['success' => 'Успешно отсортировано!']);
    }

    public function sort(Request $request, $id, $direction){
        if(isset($id)){
            $item = School::find($id);
            if($direction === 'up') $next_item = School::where('sort_id', '>', $item->sort_id)->where('lang', $item->lang)->where('category', $item->category)->orderBy('sort_id', 'asc')->first();
            else $next_item = School::where('sort_id', '<', $item->sort_id)->where('lang', $item->lang)->where('category', $item->category)->orderBy('sort_id', 'desc')->first();
            if(!$next_item) return redirect()->back();
            return $item->swapSort($item, $next_item)  ?
                redirect()->back()->with(['success' => 'Услуга успешно отредактирована!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

}
