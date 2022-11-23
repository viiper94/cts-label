<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SchoolTeacher;
use Illuminate\Http\Request;

class AdminSchoolTeachersController extends Controller{

    public function index(){
        return view('admin.school.teachers', [
            'teachers_lang' => SchoolTeacher::where('category', 'teachers')->orderBy('lang')->orderBy('sort_id')->get()->groupBy('lang'),
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'string|required',
            'course_alt' => 'string|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
        ]);
        $teacher = new SchoolTeacher();
        $teacher->fill($request->post());
        $teacher->category = 'teachers';
        if($request->hasFile('image')){
            // upload new image
            $image = $request->file('image');
            $teacher->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/school/teachers'), $teacher->image);
        }
        return $teacher->save() ?
            redirect()->route('school.teachers.index')->with(['success' => 'Учитель успешно отредактирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function update(Request $request, SchoolTeacher $teacher){
        $this->validate($request, [
            'name' => 'string|required',
            'course_alt' => 'string|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
        ]);
        $teacher->fill($request->post());
        $teacher->category = 'teachers';
        if($request->hasFile('image')){
            // delete old image
            $path = public_path('images/school/teachers/').$teacher->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
            // upload new image
            $image = $request->file('image');
            $teacher->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/school/teachers'), $teacher->image);
        }
        return $teacher->save() ?
            redirect()->route('school.teachers.index')->with(['success' => 'Учитель успешно отредактирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(SchoolTeacher $teacher){
        if($teacher->image){
            $path = public_path('images/school/'.$teacher->category.'/').$teacher->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
        }
        return $teacher->delete() ?
            redirect()->back()->with(['success' => 'Успешно удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function resort(Request $request){
        if(!$request->ajax()) abort(404);
        foreach($request->post('data') as $sort => $id){
            SchoolTeacher::find($id)->update(['sort_id' => $sort]);
        }
        return response()->json('OK');
    }


}
