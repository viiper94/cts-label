<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ArtistDoc;
use App\Track;

class AdminArtistsDocsController extends Controller
{

    public function index(Request $request){
        $query = ArtistDoc::with('tracks');
         if($request->input('q')){
            $query->where(function ($q) use ($request) {
                $q->where('filename', 'like', "%{$request->input('q')}%")
                    ->orWhereHas('tracks', function($q) use ($request){
                        $q->where('name', 'like', '%'.$request->input('q').'%')
                            ->orWhere('artists', 'like', '%'.$request->input('q').'%')
                            ->orWhere('remixers', 'like', '%'.$request->input('q').'%')
                            ->orWhere('isrc', 'like', '%'.$request->input('q').'%');
                });
            });
        }
        return view('admin.artists.docs.index', [
            'docs' => $query->latest()->paginate(30)
        ]);
    }

    public function create(Request $request){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.artists.docs.create', ['doc' => new ArtistDoc()])->render()
        ]);
    }

    public function searchTracks(Request $request){
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
            'modal' => view('admin.artists.docs.tracks_search', [
                'tracks' => $tracks
            ])->render()
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'files' => 'required|array',
            'files.*' => 'required|file',
            'tracks' => 'required|array',
            'tracks.*' => 'exists:tracks,id'
        ]);

        foreach($request->file('files') as $file){
            $doc = new ArtistDoc();
            $doc->filename = $doc->saveFile($file);
            $doc->artist_id = '1';
            $doc->save();
            $doc->tracks()->sync($request->post('tracks'));
        }

        return redirect()->route('artists.docs.index')->with(['success' => trans('artists.docs.artist_docs_added')]);
            
    }

    public function destroy(ArtistDoc $doc){
        $doc->deleteFiles($doc->filename);
        return $doc->delete() ?
            redirect()->route('artists.docs.index')->with(['success' => trans('artists.docs.artist_docs_deleted')]) :
            redirect()->route('artists.docs.index')->with(['error' => trans('alert.error')]);
    }

}
