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

}
