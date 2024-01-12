<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Release;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AdminReleasesController extends Controller{

    public function index(Request $request){
        $releases = Release::with('feedback');
        if($request->query('q')) $releases->where('title', 'like', '%' . $request->query('q') . '%')
            ->orWhere('tracklist', 'like', '%' . $request->query('q') . '%')
            ->orWhere('release_number', 'like', '%' . $request->query('q') . '%');
        return view('admin.releases.index', [
            'releases' => $releases->orderBy('sort_id', 'desc')->paginate(30)->onEachSide(1)
        ]);
    }

    public function create(){
        return view('admin.releases.edit', [
            'release_list' => Release::orderBy('sort_id', 'desc')->get(),
            'release' => new Release(),
            'prev' => null,
            'next' => null,
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|string',
            'release_number' => 'string|nullable|unique:releases,release_number',
            'genre' => 'string|nullable',
            'title' => 'required|string|max:191',
            'genre' => 'string|nullable|max:191',
            'release_date' => 'date_format:Y-m-d|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpg,jpeg,png',
            'beatport' => 'url|nullable|max:191',
            'youtube' => 'url|nullable|max:191',
            'related' => 'array',
        ]);
        $release = new Release();
        $release->fill($request->post());
        $release->release_date = $request->date('release_date');
        $release->sort_id = intval($release->getLatestSortId(Release::class)) + 1;
        if($request->hasFile('image')){
            $release->saveImage($request->file('image'));
        }
        if($release->save()){
            $release->tracks()->attach($request->post('tracks'));
            $release->related()->attach($request->post('related'));
            return redirect()->route('releases.index')->with(['success' => trans('releases.release_added')]);
        }else{
            return redirect()->back()->withErrors([trans('alert.error')]);
        }
    }

    public function edit($id){
        $release = Release::with('related', 'tracks')->findOrFail($id);
        return view('admin.releases.edit', [
            'release_list' => Release::orderBy('sort_id', 'desc')->get(),
            'release' => $release,
            'prev' => Release::where('sort_id', '<', $release->sort_id)->orderBy('sort_id', 'desc')->first(),
            'next' => Release::where('sort_id', '>', $release->sort_id)->orderBy('sort_id', 'asc')->first(),
        ]);
    }

    public function update(Release $release, Request $request){
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'release_number' => ['string', 'nullable', Rule::unique('releases')->ignore($release), ['max', 191]],
            'genre' => 'string|nullable|max:191',
            'release_date' => 'date_format:Y-m-d|nullable',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpg,jpeg,png',
            'beatport' => 'url|nullable|max:191',
            'youtube' => 'url|nullable|max:191',
            'related' => 'array',
        ]);
        $release->fill($request->post());
        $release->release_date = $request->date('release_date');
        $release->auditSync('related', $request->post('related'));
        $release->tracks()->detach(Arr::pluck($release->tracks, 'id'));
        $release->auditAttach('tracks', $request->post('tracks'));
        if($request->hasFile('image')){
            $release->deleteImages();
            $release->saveImage($request->file('image'));
        }
        return $release->save() ?
            redirect()->route('releases.index')->with(['success' => trans('releases.release_edited')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function destroy(Release $release){
        $release->related()->detach();
        if($release->image){
            $release->deleteImages();
        }
        return $release->delete() ?
            redirect()->route('releases.index')->with(['success' => trans('releases.release_deleted')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function resort(Request $request){
        foreach($request->post('sort') as $id => $sort){
            $release = Release::find($id);
            $release->sort_id = $sort;
            $release->save();
        }
        return redirect()->back()->with(['success' => trans('releases.releases_sorted')]);
    }

    public function sort(Release $release, $direction){
        if($direction === 'up') $next_release = Release::where('sort_id', '>', $release->sort_id)->orderBy('sort_id', 'asc')->first();
        else $next_release = Release::where('sort_id', '<', $release->sort_id)->orderBy('sort_id', 'desc')->first();
        if(!$next_release) return redirect()->back();
        return $release->swapSort($release, $next_release) ?
            redirect()->back()->with(['success' => trans('releases.release_edited')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function searchRelated(Request $request){
        if($request->ajax() && $request->input('query')){
            $result = Release::select('id', 'title')
                ->where($request->post('searchBy'), 'like', '%' . $request->post('query') . '%')
                ->orderBy('sort_id', 'desc')->get();
            $parent = $request->post('id') ? Release::with('related')->find($request->post('id')) : null;
            $response = array();
            foreach($result as $release){
                $release['html'] .= view('admin.releases.search_related', [
                    'item' => $release,
                    'checked' => $parent && $parent->related->contains($release)
                ])->render();
                $release = $release->toArray();
                $release['checked'] = $parent && $parent->related->contains($release);
                $response[] = $release;
            }
            return response()->json([
                'data' => $response,
                'status' => empty($response) ? trans('releases.no_results') : 'ok',
            ]);
        }else{
            abort(404);
        }
    }

    public function translate(Request $request){
        if($request->ajax() && $request->post('query')){
            $query = html_entity_decode($request->post('query'));
            $query = str_replace('&nbsp;', ' ', $query);
            $query = str_replace('\n', ' \n ', $query);
            $query = trim($query);
            if(strlen($query) > 0){
                $tr = new GoogleTranslate();
                $tr->setSource('en');
                $tr->setTarget($request->post('target'));
                try{
                    $response['data'] = $tr->translate($query);
                    $response['status'] = 'ok';
                    $response['messages']['body'] = trans('releases.translated_successfully');
                }catch(\ErrorException $e){
                    $response['status'] = $e;
                    $response['messages']['body'] = trans('releases.translated_with_error');
                }
            }else{
                $response['status'] = 'nothing to translate';
            }
            return response()->json($response);
        }else{
            abort(404);
        }
    }

    public function addTrack(Request $request){
        if(!$request->ajax()) abort(403);
        return response()->json([
            'html' => view('admin.tracks.release_tracklist_item', [
                'track' => Track::findOrFail($request->post('id'))
            ])->render()
        ]);
    }

    public function generateReleaseNumber(Request $request){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'cat' => Release::generateReleaseNumber()
        ]);
    }

    public function labelCopy(Release $release){
        $release->label_copy_zip = $release->createLabelCopy();
        return $release->save() ?
            redirect()->back()->with(['success' => trans('releases.label_copy_generated')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

}
