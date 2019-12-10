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

    public function edit(Request $request, $id){
        if($request->post() && $id){
            $this->validate($request, [
                'name' => 'required|string',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png',
                'link' => 'url|nullable'
            ]);
            $artist = Artist::find($id);
            $artist->fill($request->post());
            $artist->visible =  $request->input('visible') == 'on';
            if($request->hasFile('image')){
                // delete old image
                $path = public_path('images/artists/').$artist->image;
                if(file_exists($path) && is_file($path)){
                    unlink($path);
                }
                // upload new image
                $image = $request->file('image');
                $artist->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/artists'), $artist->image);
            }
            return $artist->save() ?
                redirect()->route('artists_admin')->with(['success' => 'Артист успешно отредактирован!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return view('admin.artists.edit', [
            'artist' => Artist::findOrFail($id)
        ]);
    }

    public function add(Request $request){
        $artist = new Artist();
        if($request->post()){
            $this->validate($request, [
                'name' => 'required|string',
                'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png',
                'link' => 'url|nullable'
            ]);
            $artist->fill($request->post());
            $artist->visible =  $request->input('visible') == 'on';
            $artist->sort_id =  intval(Artist::getLatestSortId()) + 1;
            if($request->hasFile('image')){
                $image = $request->file('image');
                $artist->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/artists'), $artist->image);
            }
            return $artist->save() ?
                redirect()->route('artists_admin')->with(['success' => 'Артист успешно добавлен!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return view('admin.artists.edit', [
            'artist' => $artist
        ]);
    }

    public function delete(Request $request, $id){
        if($id){
            $artist = Artist::find($id);
            if($artist->image){
                // delete image
                $path = public_path('images/artists/').$artist->image;
                if(file_exists($path) && is_file($path)){
                    unlink($path);
                }
            }
            return $artist->delete() ?
                redirect()->back()->with(['success' => 'Артист успешно удалён!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    public function resort(Request $request){
        foreach($request->post('sort') as $id => $sort){
            $artist = Artist::find($id);
            $artist->sort_id = $sort;
            $artist->save();
        }
        return redirect()->back()->with(['success' => 'Артисты успешно отсортированы!']);
    }

    public function sortup(Request $request, $id){
        if(isset($id)){
            $artist = Artist::find($id);
            $up_artist = Artist::where('sort_id', '>', $artist->sort_id)->orderBy('sort_id', 'asc')->first();
            if(!$up_artist) return redirect()->back();
            return $this->swapSort($artist, $up_artist)  ?
                redirect()->back()->with(['success' => 'Артист успешно отредактирован!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    public function sortdown(Request $request, $id){
        if(isset($id)){
            $artist = Artist::find($id);
            $down_artist = Artist::where('sort_id', '<', $artist->sort_id)->orderBy('sort_id', 'desc')->first();
            if(!$down_artist) return redirect()->back();
            return $this->swapSort($artist, $down_artist) ?
                redirect()->back()->with(['success' => 'Артист успешно отредактирован!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

    private function swapSort($artist, $slave_artist){
        $tmp = $artist->sort_id;
        $artist->sort_id = $slave_artist->sort_id;
        $slave_artist->sort_id = $tmp;
        return $artist->save() && $slave_artist->save();
    }

}
