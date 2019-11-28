<?php

namespace App\Http\Controllers;

use App\Release;
use Illuminate\Http\Request;

class ReleasesController extends Controller{

    public function index(Request $request){
        $query = Release::where('visible', 1);
        if($request->input('q')){
            $query->where('title', 'like', '%'.$request->input('q').'%');
        }
        return view('releases.index', [
            'releases' => $query->orderBy('sort_id', 'desc')->paginate(15)->onEachSide(1)
        ]);
    }

    public function show(Request $request, $id){
        $release = Release::with('related')->findOrFail($id);
        return view('releases.release', [
            'release' => $release,
            'prev' => Release::where([
                ['visible', '=', 1],
                ['sort_id', '<', $release->sort_id]
            ])->orderBy('sort_id', 'desc')->first(),
            'next' => Release::where([
                ['visible', '=', 1],
                ['sort_id', '>', $release->sort_id]
            ])->first(),
            'related' => []
        ]);
    }

}
