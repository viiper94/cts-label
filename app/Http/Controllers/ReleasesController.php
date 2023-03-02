<?php

namespace App\Http\Controllers;

use App\Release;
use Illuminate\Http\Request;

class ReleasesController extends Controller{

    public function index(Request $request){
        $query = Release::whereVisible(1);
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
            'prev' => Release::whereVisible(1)->where('sort_id', '<', $release->sort_id)->orderBy('sort_id', 'desc')->first(),
            'next' => Release::whereVisible(1)->where('sort_id', '>', $release->sort_id)->orderBy('sort_id', 'asc')->first()
        ]);
    }

    public function rss(){
        app()->setLocale('en');
        $releases = Release::whereVisible(1)->limit(50)->orderBy('sort_id', 'desc')->get();
        return response()
            ->view('releases.rss', compact('releases'))
            ->header('Content-Type', 'application/xml');
    }

}
