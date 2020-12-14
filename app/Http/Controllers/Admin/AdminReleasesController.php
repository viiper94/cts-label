<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Release;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AdminReleasesController extends Controller{

    public function index(Request $request){
        $releases = Release::select(['id', 'sort_id', 'title', 'image', 'release_number']);
        if($request->input('q')) $releases->where('title', 'like', '%'.$request->input('q').'%')
            ->orWhere('tracklist', 'like', '%'.$request->input('q').'%')
            ->orWhere('release_number', 'like', '%'.$request->input('q').'%');
        return view('admin.releases.index', [
            'releases' => $releases->orderBy('sort_id', 'desc')->paginate(30)
        ]);
    }

    public function edit(Request $request, $id){
        if($request->post() && $id){
            $this->validate($request, [
                'title' => 'required|string',
                'release_number' => 'string|nullable',
                'release_date' => 'date_format:d F Y|nullable',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpg,jpeg,png',
                'beatport' => 'url|nullable',
                'youtube' => 'url|nullable',
                'related' => 'array',
            ]);
            $release = Release::with('related')->find($id);
            $release->fill($request->post());
            $release->release_date = date('Y-m-d', strtotime($request->input('release_date')));
            $release->visible =  $request->input('visible') == 'on';
            if($request->hasFile('image')){
                // delete old image
                $path = public_path('images/releases/').$release->image;
                if(file_exists($path) && is_file($path)){
                    unlink($path);
                }
                // upload new image
                $image = $request->file('image');
                $release->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/releases'), $release->image);
            }
            return $release->save() ?
                redirect()->route('releases_admin')->with(['success' => 'Релиз успешно отредактирован!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return view('admin.releases.edit', [
            'release_list' => Release::orderBy('sort_id', 'desc')->get(),
            'release' => Release::with('related')->findOrFail($id)
        ]);
    }

    public function add(Request $request){
        $release = new Release();
        if($request->post()){
            $this->validate($request, [
                'title' => 'required|string',
                'release_number' => 'string|nullable',
                'release_date' => 'date_format:d F Y|nullable',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpg,jpeg,png',
                'beatport' => 'url|nullable',
                'youtube' => 'url|nullable',
                'related' => 'array',
            ]);
            $release->fill($request->post());
            $release->release_date = date('Y-m-d', strtotime($request->input('release_date')));
            $release->sort_id =  intval($release->getLatestSortId(Release::class)) + 1;
            $release->visible =  $request->input('visible') == 'on';
            if($request->hasFile('image')){
                $image = $request->file('image');
                $release->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/releases'), $release->image);
            }
            if($release->save()){
                $release->renewRelatedReleases($request->post('related'));
                return redirect()->route('releases_admin')->with(['success' => 'Релиз успешно добавлен!']);
            }else{
                return redirect()->back()->withErrors(['Возникла ошибка =(']);
            }
        }
        return view('admin.releases.edit', [
            'release_list' => Release::orderBy('sort_id', 'desc')->get(),
            'release' => $release
        ]);
    }

    public function resort(Request $request){
        foreach($request->post('sort') as $id => $sort){
            $release = Release::find($id);
            $release->sort_id = $sort;
            $release->save();
        }
        return redirect()->back()->with(['success' => 'Релизы успешно отсортированы!']);
    }

    public function sort(Request $request, $id, $direction){
        if(isset($id)){
            $release = Release::find($id);
            if($direction === 'up') $next_release = Release::where('sort_id', '>', $release->sort_id)->orderBy('sort_id', 'asc')->first();
            else $next_release = Release::where('sort_id', '<', $release->sort_id)->orderBy('sort_id', 'desc')->first();
            if(!$next_release) return redirect()->back();
            return $release->swapSort($release, $next_release)  ?
                redirect()->back()->with(['success' => 'Релиз успешно отредактирован!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    public function searchRelated(Request $request){
        if($request->ajax() && $request->input('query')){
            $result = Release::select('id', 'title')->where($request->post('searchBy'), 'like', '%'.$request->post('query').'%')
                ->orderBy('sort_id', 'desc')->get();
            $parent = $request->post('id') ? Release::with('related')->find($request->post('id')) : null;
            $response = array();
            foreach($result as $release){
                $checked = false;
                if($parent && $parent->related->contains($release)) $checked = true;
                $release = $release->toArray();
                $release['checked'] = $checked;
                $response[] = $release;
            }
            return response()->json([
                'data' => $response,
                'status' => 'ok',
            ]);
        }else{
            abort(404);
            return false;
        }
    }

    public function delete(Request $request, $id){
        if($id){
            $release = Release::find($id);
            $release->related()->detach();
            if($release->image){
                // delete image
                $path = public_path('images/releases/').$release->image;
                if(file_exists($path) && is_file($path)){
                    unlink($path);
                }
            }
            return $release->delete() ?
                redirect()->back()->with(['success' => 'Релиз успешно удалён!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    public function translate(Request $request){
        if($request->ajax() && $request->post('query')){
            $query = strip_tags($request->post('query'));
            $query = str_replace('&nbsp;', ' ', $query);
            $query = str_replace('\n', ' \n ', $query);
            $query = trim($query);
            if(strlen($query) > 0){
                $tr = new GoogleTranslate();
                $tr->setSource('en');
                $tr->setTarget($request->post('target'));
                try{
                    $response['data'] = $tr->translate($query);
                    $response['status'] = 'ok';
                }catch(\ErrorException $e){
                    $response['status'] = $e;
                }
            }else{
                $response['status'] = 'nothing to translate';
            }
            return response()->json($response);
        }else{
            abort(404);
            return false;
        }
    }

}
