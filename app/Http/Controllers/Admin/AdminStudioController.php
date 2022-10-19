<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StudioService;
use Illuminate\Http\Request;

class AdminStudioController extends Controller{

    public function index(Request $request){
        $services = StudioService::orderBy('sort_id', 'desc');
        if($request->input('q')) $services->where('name', 'like', '%'.$request->post('q').'%');
        return view('admin.studio', [
            'service_list' => $services->get()->sortBy('sort_id')->groupBy('lang')
        ]);
    }

    public function store(Request $request){
        $service = new StudioService();
        $this->validate($request, [
            'lang' => 'string|required',
            'name' => 'string|required',
            'service_alt' => 'string|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
        ]);
        $service->fill($request->post());
        $service->category = 'services';
        $service->sort_id = intval($service->getLatestSortId(StudioService::class) + 1);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $service->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/studio/services'), $service->image);
        }
        return $service->save() ?
            redirect()->route('studio.index')->with(['success' => 'Услуга успешно добавлена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'lang' => 'string|required',
            'name' => 'string|required',
            'service_alt' => 'string|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
        ]);
        $service = StudioService::findOrFail($id);
        $service->fill($request->post());
        $service->category = 'services';
        if($request->hasFile('image')){
            // delete old image
            $path = public_path('images/studio/services/').$service->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
            // upload new image
            $image = $request->file('image');
            $service->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/studio/services'), $service->image);
        }
        return $service->save() ?
            redirect()->route('studio.index')->with(['success' => 'Услуга успешно отредактирована!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(Request $request, $id){
        $service = StudioService::find($id);
        if($service->image){
            // delete image
            $path = public_path('images/studio/services/').$service->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
        }
        return $service->delete() ?
            redirect()->back()->with(['success' => 'Услуга успешно удалена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function resort(Request $request){
        if($request->ajax()){
            foreach($request->post('data') as $sort => $id){
                StudioService::find($id)->update(['sort_id' => $sort]);
            }
            return response()->json('OK');
        }
        return redirect()->route('studio_admin');
    }

}
