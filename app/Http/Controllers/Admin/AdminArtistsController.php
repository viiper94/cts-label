<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Artist;
use Illuminate\Http\Request;

class AdminArtistsController extends Controller{

    public function index(Request $request){
        $artists = Artist::select('id', 'sort_id', 'name', 'link', 'image');
        if($request->input('q')) $artists->where('name', 'like', '%'.$request->input('q').'%');
        return view('admin.artists.index', [
            'artists' => $artists->orderBy('sort_id', 'desc')->paginate(30)
        ]);
    }

    public function create(){
        return view('admin.artists.edit', [
            'artist' => new Artist()
        ]);
    }

    public function store(Request $request){
        $artist = new Artist();
        if($request->post()){
            $this->validate($request, [
                'name' => 'required|string',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png',
                'link' => 'url|nullable'
            ]);
            $artist->fill($request->post());
            $artist->sort_id = intval($artist->getLatestSortId(Artist::class)) + 1;
            if($request->hasFile('image')){
                $artist->saveImage($request->file('image'));
            }
            return $artist->save() ?
                redirect()->route('artists.index')->with(['success' => 'Артист успешно добавлен!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return view('admin.artists.edit', [
            'artist' => $artist
        ]);
    }

    public function edit(Artist $artist){
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Artist $artist, Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png',
            'link' => 'url|nullable'
        ]);
        $artist->fill($request->post());
        if($request->hasFile('image')){
            $artist->deleteImages();
            $artist->saveImage($request->file('image'));
        }
        return $artist->save() ?
            redirect()->route('artists.index')->with(['success' => 'Артист успешно отредактирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(Artist $artist){
        $artist->deleteImages();
        return $artist->delete() ?
            redirect()->route('artists.index')->with(['success' => 'Артист успешно удалён!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function resort(Request $request){
        foreach($request->post('sort') as $id => $sort){
            $artist = Artist::find($id);
            $artist->sort_id = $sort;
            $artist->save();
        }
        return redirect()->back()->with(['success' => 'Артисты успешно отсортированы!']);
    }

    public function sort(Artist $artist, $dir){
        if($dir === 'up') $next_artist = Artist::where('sort_id', '>', $artist->sort_id)->orderBy('sort_id', 'asc')->first();
        else $next_artist = Artist::where('sort_id', '<', $artist->sort_id)->orderBy('sort_id', 'desc')->first();
        if(!$next_artist) return redirect()->back();
        return $artist->swapSort($artist, $next_artist)  ?
            redirect()->back()->with(['success' => 'Артист успешно отредактирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

}
