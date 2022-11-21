<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\School;
use App\SchoolCourse;
use Illuminate\Http\Request;

class AdminSchoolCoursesController extends Controller{

    public function index(Request $request){
        return view('admin.school.courses', [
            'courses_lang' => SchoolCourse::where('category', 'courses')->orderBy('sort_id')->get()->groupBy('lang'),
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
            // upload new image
            $image = $request->file('image');
            $course->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/school/courses'), $course->image);
        }
        return $course->save() ?
            redirect()->route('school_admin')->with(['success' => 'Услуга успешно отредактирована!']) :
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
    }

    public function destroy(SchoolCourse $course){
        if($course->image){
            $path = public_path('images/school/'.$course->category.'/').$course->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
        }
        return $course->delete() ?
            redirect()->back()->with(['success' => 'Успешно удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
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
