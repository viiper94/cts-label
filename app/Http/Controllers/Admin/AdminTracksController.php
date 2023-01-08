<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function Termwind\render;

class AdminTracksController extends Controller{

    public function index(Request $request){
        $tracks = Track::with('releases');
        if($request->input('q')){
            $tracks = $tracks->where('name', 'like', '%'.$request->input('q').'%')
                ->orWhere('artists', 'like', '%'.$request->input('q').'%')
                ->orWhere('mix_name', 'like', '%'.$request->input('q').'%')
                ->orWhere('isrc', 'like', '%'.$request->input('q').'%')
                ->orWhere('genre', 'like', '%'.$request->input('q').'%');
        }
        if($request->input('sort')){
            $tracks = $tracks->orderBy($request->input('sort'), ($request->input('dir') === 'down') ? 'desc' : 'asc');
        }
        return view('admin.tracks.index', [
            'tracks' => $tracks->orderBy('isrc', 'desc')->orderBy('beatport_id', 'desc')->paginate(30)
        ]);
    }

    public function create(Request $request){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'modal' => view('admin.tracks.edit', [
                'track' => new Track()
            ])->render(),
        ]);
    }

    public function store(Request $request){
        if(!$request->ajax()) abort(404);
        $this->validate($request, [
            'name' => 'string|required',
            'mix_name' => 'string|nullable',
            'artists' => 'string|required',
            'remixers' => 'string|nullable',
            'composer' => 'string|nullable',
            'isrc' => 'string|required|unique:tracks,isrc',
            'bpm' => 'numeric|nullable',
            'genre' => 'string|nullable',
            'length' => 'string|nullable',
            'youtube' => 'url|nullable',
            'beatport_id' => 'string|nullable',
            'beatport_slug' => 'string|nullable',
            'beatport_release_id' => 'string|nullable',
            'beatport_wave' => 'url|nullable',
            'beatport_sample' => 'url|nullable',
            'beatport_sample_start' => 'string|nullable',
            'beatport_sample_end' => 'string|nullable'
        ]);
        session($request->post());
        $track = new Track();
        $track->fill($request->post());
        $track->remixers = explode(',' , $request->post('remixers'));
        return response()->json($track->save()
            ? ['id' => $track->id, 'url' => route('releases.add_track')]
            : ['error' => 'Возникла ошибка =(']);
    }

    public function edit(Request $request, Track $track){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'modal' => view('admin.tracks.edit', [
                'track' => $track
            ])->render(),
        ]);
    }

    public function update(Request $request, Track $track){
        if(!$request->ajax()) abort(404);
        $this->validate($request, [
            'name' => 'string|required',
            'mix_name' => 'string|nullable',
            'artists' => 'string|required',
            'remixers' => 'string|nullable',
            'composer' => 'string|nullable',
            'isrc' => ['string', 'required', Rule::unique('tracks', 'isrc')->ignore($track->id)],
            'bpm' => 'numeric|nullable',
            'genre' => 'string|nullable',
            'length' => 'string|nullable',
            'youtube' => 'url|nullable',
            'beatport_id' => 'string|nullable',
            'beatport_slug' => 'string|nullable',
            'beatport_release_id' => 'string|nullable',
            'beatport_wave' => 'url|nullable',
            'beatport_sample' => 'url|nullable',
            'beatport_sample_start' => 'string|nullable',
            'beatport_sample_end' => 'string|nullable'
        ]);
        $track->fill($request->post());
        $track->remixers = explode(',' , $request->post('remixers'));
        return response()->json($track->save()
            ? ['id' => $track->id, 'url' => route('releases.add_track')]
            : ['error' => 'Возникла ошибка =(']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        //
    }

    public function search(Request $request){
        if(!$request->ajax()) abort(404);
        $query = trim($request->post('query'));
        $tracks = Track::with('releases')
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('artists', 'like', '%'.$query.'%')
            ->orWhere('mix_name', 'like', '%'.$query.'%')
            ->orWhere('isrc', 'like', '%'.$query.'%')
            ->orWhereRelation('releases', 'title', 'like', '%'.$query.'%')
            ->orderBy('id', 'desc')->get();
        return response()->json([
            'modal' => view('admin.tracks.search', [
                'tracks' => $tracks
            ])->render()
        ]);
    }

    public function generateISRCCode(Request $request){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'isrc' => Track::generateISRCCode()
        ]);
    }

    public function updateTrack(Request $request){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.tracks.tracks_item', [
                'track' => Track::with('releases')->findOrFail($request->post('id'))
            ])->render()
        ]);
    }

}
