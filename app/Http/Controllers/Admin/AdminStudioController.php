<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StudioService;
use Illuminate\Http\Request;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class AdminStudioController extends Controller{

    public function index(Request $request){
        return view('admin.studio', [
            'service_list' => StudioService::orderBy('lang')->orderBy('sort_id')->get()->groupBy('lang')
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
            $service->image = md5($image->getClientOriginalName(). time()).'.webp';
            Image::load($image->getPathname())->width(185)->format(Manipulations::FORMAT_WEBP)->save(public_path('images/school/courses/').$service->image);
        }
        return $service->save() ?
            redirect()->route('studio.index')->with(['success' => 'Услуга успешно добавлена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function update(StudioService $studio, Request $request){
        $this->validate($request, [
            'lang' => 'string|required',
            'name' => 'string|required',
            'service_alt' => 'string|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png'
        ]);
        $studio->fill($request->post());
        $studio->category = 'services';
        if($request->hasFile('image')){
            // delete old image
            $path = public_path('images/studio/services/').$studio->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
            // upload new image
            $image = $request->file('image');
            $studio->image = md5($image->getClientOriginalName(). time()).'.webp';
            Image::load($image->getPathname())->width(185)->format(Manipulations::FORMAT_WEBP)->save(public_path('images/school/courses/').$studio->image);
        }
        return $studio->save() ?
            redirect()->route('studio.index')->with(['success' => 'Услуга успешно отредактирована!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(StudioService $studio){
        if($studio->image){
            // delete image
            $path = public_path('images/studio/services/').$studio->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
        }
        return $studio->delete() ?
            redirect()->back()->with(['success' => 'Услуга успешно удалена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function resort(Request $request){
        if(!$request->ajax()) abort(404);
        foreach($request->post('data') as $sort => $id){
            StudioService::find($id)->update(['sort_id' => $sort]);
        }
        return response()->json('OK');
    }

}
