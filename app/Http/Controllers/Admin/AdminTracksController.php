<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TracksExport;
use App\Http\Controllers\Controller;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Excel;
use function Termwind\render;

class AdminTracksController extends Controller{

    public function index(Request $request){
        $tracks = Track::with('releases')->withCount('reviews', 'also_supported');
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
            'tracks' => $tracks->latest()->paginate(30)
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
            'name' => 'string|required|max:191',
            'mix_name' => 'string|nullable|max:191',
            'artists' => 'string|required',
            'remixers' => 'string|nullable',
            'composer' => 'string|nullable|max:191',
            'isrc' => 'string|nullable|unique:App\Track|max:191',
            'bpm' => 'numeric|nullable',
            'genre' => 'string|nullable|max:191',
            'length' => 'string|nullable',
            'youtube' => 'url|nullable',
            'beatport_id' => 'string|nullable',
            'beatport_slug' => 'string|nullable|max:191',
            'beatport_release_id' => 'string|nullable',
            'beatport_wave' => 'url|nullable',
            'beatport_sample' => 'url|nullable',
            'beatport_sample_start' => 'string|nullable',
            'beatport_sample_end' => 'string|nullable'
        ]);
        session($request->post());
        $track = new Track();
        $track->fill($request->post());
        $track->mix_name = $request->post('mix_name') ?? 'Original Mix';
        $track->remixers = explode(',' , $request->post('remixers'));
        return response()->json($track->save()
            ? [
                'id' => $track->id,
                'url' => route('releases.add_track'),
                'message' => trans('tracks.track_added')
            ]
            : ['error' => trans('alert.error')]);
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
            'name' => 'string|required|max:191',
            'mix_name' => 'string|nullable|max:191',
            'artists' => 'string|required',
            'remixers' => 'string|nullable',
            'composer' => 'string|nullable|max:191',
            'isrc' => ['string', 'nullable', Rule::unique('tracks')->ignore($track), ['max', 191]],
            'bpm' => 'numeric|nullable',
            'genre' => 'string|nullable|max:191',
            'length' => 'string|nullable',
            'youtube' => 'url|nullable',
            'beatport_id' => 'string|nullable',
            'beatport_slug' => 'string|nullable|max:191',
            'beatport_release_id' => 'string|nullable',
            'beatport_wave' => 'url|nullable',
            'beatport_sample' => 'url|nullable',
            'beatport_sample_start' => 'string|nullable',
            'beatport_sample_end' => 'string|nullable'
        ]);
        session($request->post());
        $track->fill($request->post());
        $track->remixers = explode(',' , $request->post('remixers'));
        return response()->json($track->save()
            ? [
                'id' => $track->id,
                'url' => route('releases.add_track'),
                'message' => trans('tracks.track_edited')
            ]
            : ['error' => trans('alert.error')]);
    }


    public function destroy(Track $track){
        return $track->delete() ?
            redirect()->route('tracks.index')->with(['success' => trans('tracks.track_deleted')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
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

    public function checkISRCCode(Request $request){
        if(!$request->ajax()) abort(404);
        $track = Track::select(['id', 'artists', 'name', 'mix_name', 'isrc'])->whereIsrc($request->isrc)->first();
        return response()->json([
            'track' => $track,
            'html' => $track ? view('admin.tracks.already_exists', compact('track'))->render() : null
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

    public function export(){
        try{
            $tracks = Track::with('releases')->orderBy('isrc')->get();
            $file_name = 'CTS Catalogue.xlsx';

            return (new TracksExport($tracks))->download(
                $file_name,
                Excel::XLSX,
                ['Content-Type' => 'text/xlsx']
            );

        }catch(\Exception $e){
            return redirect()->back()->withErrors([trans('alert.error') => $e->getMessage()]);
        }
    }

    public function updateShowReviews(Request $request, Track $track){
        if(!$request->ajax()) abort(404);
        $track->show_reviews = $request->post('show_reviews') === 'true';
        return $track->save() ?
            response()->json([
                'message' => trans('alert.success'),
            ]) :
            response()->json([
                'error' => trans('alert.error'),
            ], 500);
    }

}
