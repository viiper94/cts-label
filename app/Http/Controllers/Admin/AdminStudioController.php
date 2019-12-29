<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StudioService;
use Illuminate\Http\Request;

class AdminStudioController extends Controller{

    public function index(Request $request){
        $services = StudioService::select(['*']);
        if($request->input('q')) $services->where('name', 'like', '%'.$request->post('q').'%');
        return view('admin.studio.index', [
            'services' => $services->orderBy('sort_id', 'desc')->get()
        ]);
    }

    public function add(Request $request){
        $service = new StudioService();
        if($request->post()){
            $this->validate($request, [
                'name' => 'string|required',
                'service_alt' => 'string|nullable',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
            ]);
            $service->fill($request->post());
            $service->category = 'services';
            $service->visible = $request->input('visible') == 'on';
            $service->sort_id = intval($service->getLatestSortId(StudioService::class) + 1);
            if($request->hasFile('image')){
                $image = $request->file('image');
                $service->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/studio/services'), $service->image);
            }
            return $service->save() ?
                redirect()->route('studio_admin')->with(['success' => 'Услуга успешно добавлена!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return view('admin.studio.edit', [
            'service' => $service
        ]);
    }

}
