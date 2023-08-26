<?php

namespace App\Http\Controllers;

use App\Release;
use App\Track;
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

    public function track(Request $request, Track $track, Release $release = null){
        if(!$request->ajax()) abort(404);
        $length = stripos($track->length, ':') ? Track::minutesToMilliseconds($track->length) : (int) $track->length;
        $start = stripos($track->beatport_sample_start, ':') ? Track::minutesToMilliseconds($track->beatport_sample_start) : (int) $track->beatport_sample_start;
        $end = stripos($track->beatport_sample_end, ':') ? Track::minutesToMilliseconds($track->beatport_sample_end) : (int) $track->beatport_sample_end;
        return response()->json([
            'wave' => $track->beatport_wave,
            'sampleStart' => $start,
            'length' => $length,
            'url' => $track->beatport_sample,
            'html' => view('releases.player', [
                'track' => $track,
                'release' => $release ?? $track->release,
                'wave' => $track->beatport_wave,
                'ml' => $start/$length * 100,
                'left' => $end/$length * 100,
                'right' => 100 - $start/$length * 100,
                'width' => $end/$length * 100 - $start/$length * 100,
                'bp' => 432.16 * $start/$length
            ])->render()
        ]);
    }

}
