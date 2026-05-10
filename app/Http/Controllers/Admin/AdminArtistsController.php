<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Artist;
use Illuminate\Http\Request;

class AdminArtistsController extends Controller{

    public function index(Request $request){
        $artists = Artist::select('*');
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
                'spotify_id' => 'nullable|string|max:191',
                'apple_music_id' => 'nullable|string|max:191',
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
                'spotify_id' => 'nullable|string|max:191',
                'apple_music_id' => 'nullable|string|max:191',
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

}
