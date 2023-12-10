<?php

namespace App\Http\Controllers\Admin;

use App\ArtistCv;
use App\Enums\CvStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminArtistsCvController extends Controller{

    public function index(){
        return view('admin.artists.cv.index', [
            'cv_list' => ArtistCv::withCount('artists_info')->orderBy('status')->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function show(ArtistCv $cv){
        $cv->load('artists_info');
        $cv->status = CvStatus::PENDING;
        $cv->save();
        return view('admin.artists.cv.show', compact('cv'));
    }

    public function destroy(ArtistCv $cv){
        return $cv->delete()
            ? redirect()->route('artists_cv.index')->with(['success' => trans('cv.cv_deleted')])
            : redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function document(ArtistCv $cv){
        $cv->doc = $cv->createDocument();
        return $cv->save()
            ? redirect()->back()->with(['success' => trans('cv.cv_generated')])
            : redirect()->back()->withErrors([trans('alert.error')]);
    }

}
