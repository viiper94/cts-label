<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Artist;
use Illuminate\Http\Request;

class AdminArtistsController extends Controller{

    public function index(Request $request){
        $artists = Artist::select('id', 'name', 'image');
        if($request->input('q')) $artists->where('name', 'like', '%'.$request->input('q').'%');
        return view('admin.artists.index', [
            'artists' => $artists->latest()->paginate(30)
        ]);
    }

    public function create(Request $request){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.artists.edit', ['artist' => new Artist()])->render()
        ]);
    }

    public function store(Request $request){
        $artist = new Artist();
        if($request->post()){
            $this->validate($request, [
                'name' => 'required|string|max:191',
                'image' => 'nullable|image|mimes:jpeg,png',
                'link' => 'url|nullable|max:191'
            ]);
            $artist->fill($request->post());
            $artist->sort_id = intval($artist->getLatestSortId(Artist::class)) + 1;
            if($request->hasFile('image')){
                $artist->saveImage($request->file('image'));
            }
            return $artist->save() ?
                redirect()->route('artists.index')->with(['success' => trans('artists.artist_added')]) :
                redirect()->back()->withErrors([trans('alert.error')]);
        }
        return view('admin.artists.edit', [
            'artist' => $artist
        ]);
    }

    public function edit(Request $request, Artist $artist){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.artists.edit', compact('artist'))->render()
        ]);
    }

    public function update(Artist $artist, Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'image' => 'nullable|image|mimes:jpeg,png',
            'link' => 'url|nullable|max:191'
        ]);
        $artist->fill($request->post());
        if($request->hasFile('image')){
            $artist->deleteImages();
            $artist->saveImage($request->file('image'));
        }
        return $artist->save() ?
            redirect()->route('artists.index')->with(['success' => trans('artists.artist_edited')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function destroy(Artist $artist){
        $artist->deleteImages();
        return $artist->delete() ?
            redirect()->route('artists.index')->with(['success' => trans('artists.artist_deleted')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function resort(Request $request){
        foreach($request->post('sort') as $id => $sort){
            $artist = Artist::find($id);
            $artist->sort_id = $sort;
            $artist->save();
        }
        return redirect()->back()->with(['success' => trans('artists.artists_sorted')]);
    }

    public function sort(Artist $artist, $dir){
        if($dir === 'up') $next_artist = Artist::where('sort_id', '>', $artist->sort_id)->orderBy('sort_id', 'asc')->first();
        else $next_artist = Artist::where('sort_id', '<', $artist->sort_id)->orderBy('sort_id', 'desc')->first();
        if(!$next_artist) return redirect()->back();
        return $artist->swapSort($artist, $next_artist)  ?
            redirect()->back()->with(['success' => trans('artists.artist_edited')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function import(){
        // read artists.json
        // iterate through "data"
        // where stores->platform_id = 0, read "third_id" it is apple music id
        // where stores->platform_id = 204, read "third_id" it is spotify id
        // artist name is "name" match with Artist::where('name', $name)->first()
        // if found, update spotify_id and apple_music_id
        // if not found, create new artist with name, spotify_id and apple_music_id, but not visible, download image, save it in public-images-artists and save the artist
        $file_name = 'artists.json';
        if(!file_exists($file_name)) return redirect()->back()->withErrors([trans('artists.file_not_found')]);
        $json = file_get_contents($file_name);
        $data = json_decode($json, true);        
        foreach($data['data'] as $item){
            $artist = Artist::where('name', $item['name'])->first();
            if(!$artist) $artist = new Artist();
            foreach($item['stores'] as $store){
                if($store['platform_id'] == 0) $artist->apple_music_id = $store['third_id'];
                elseif($store['platform_id'] == 204) $artist->spotify_id = $store['third_id'];
            }
            if(!$artist->id){
                $artist->name = $item['name'];
                $artist->sort_id = intval($artist->getLatestSortId(Artist::class)) + 1;
                $artist->visible = false;
            } 
            if(!$artist->id && $item['image']) {
                try {
                    $image_content = file_get_contents($item['image']);
                    $image_name = basename($item['image']);
                    file_put_contents(public_path('images/artists/' . $image_name), $image_content);
                    $artist->image = 'images/artists/' . $image_name;
                } catch (\Exception $e) {
                    // Handle image download error (e.g., log the error)
                }
            }
            $artist->save();
        }
        return redirect()->back()->with(['success' => trans('artists.artists_imported')]);
    }

}
