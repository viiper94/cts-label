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
            'isrc' => 'string|nullable|unique:tracks,isrc',
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
            'isrc' => ['string', 'nullable', Rule::unique('tracks', 'isrc')->ignore($track->id)],
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


    public function destroy(Track $track){
        return $track->delete() ?
            redirect()->route('tracks.index')->with(['success' => 'Трек успешно удалён!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
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

    public function import(){

        $pages = json_decode(file_get_contents(resource_path('tracks.json')), true);
//            dd($pages['page_1']['results']);

        foreach(array_reverse($pages) as $page){

            foreach(array_reverse($page['results']) as $item){

//                    dd($track['catalog_number']);

                $artists = array();
                $remixers = array();

                foreach($item['artists'] as $artist){
                    $artists[] = $artist['name'];
                }
                if(count($item['remixers']) > 0){
                    foreach($item['remixers'] as $remixer){
                        $remixers[] = $remixer['name'];
                    }
                }

                $isrc = preg_replace('/(UA)(CT1)([0-9]{2})([0-9]{5})/', '$1-$2-$3-$4', $item['isrc']);
                $track = $item['isrc'] ? \App\Track::where('isrc', $isrc)->first() : null;

                if(!$track){
                    $track = \App\Track::create([
                        'name' => $item['name'],
                        'mix_name' => $item['mix_name'],
                        'isrc' => $isrc ?? null,
                        'bpm' => $item['bpm'],
                        'genre' => $item['genre']['name'],
                        'length' => $item['length_ms'],
                        'beatport_id' => $item['id'],
                        'beatport_slug' => $item['slug'],
                        'beatport_release_id' => $item['release']['id'],
                        'beatport_wave' => $item['image']['uri'] ?? null,
                        'beatport_sample' => $item['sample_url'],
                        'beatport_sample_start' => $item['sample_start_ms'],
                        'beatport_sample_end' => $item['sample_end_ms'],
                        'artists' => implode(', ', $artists),
                        'remixers' => $remixers ?? null,
                    ]);
                }

                $catalogue = str_replace([' ', '-'], '', $item['catalog_number']);
                $release = \App\Release::where('release_number', $catalogue)->first();

                if(!$release) $release = \App\Release::where('beatport', 'like', '%'.$item['release']['id'].'%')->first();

                echo "CAT: $catalogue, $track->name ";

                $release->tracks()->attach($track->id);

                echo "    DONE <br>";
            }

        }
    }

}
