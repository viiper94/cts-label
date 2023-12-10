<?php

namespace App\Http\Controllers;

use App\ArtistContact;
use App\ArtistCv;
use App\Mail\ArtistCvMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArtistsCvController extends Controller{

    public function create(){
        return view('artists.cv.index');
    }

    public function store(Request $request){
        if(!$request->post()) abort(404);
        $this->validate($request, [
            'info' => 'min:1|required|array',
            'main_contact_name' => 'max:190|string|nullable',
            'main_contact_email' => 'max:190|string|nullable',
            'main_contact_phone' => 'max:190|string|nullable',
            'tracks_to_sign' => 'array|nullable',
        ], [
            'info' => trans('artists.cv.info_required')
        ]);
        $cv = ArtistCv::create($request->post());
        foreach($request->info as $id){
            $info = ArtistContact::find($id);
            $info->artist_cv_id = $cv->id;
            $info->save();
        }
        if($cv->save()){
            $cv->doc = $cv->createDocument();
            $cv->update();
            Mail::to(env('ADMIN_EMAIL'))->send(new ArtistCvMail($cv));
            return redirect()->route('home')->with(['success' => trans('artists.cv.cv_created')]);
        }
        return redirect()->route('home')->withErrors([trans('alert.error')]);
    }

    public function getTrackItem(Request $request){
        return response()->json([
            'html' => view('artists.cv.track_to_sign_item', [
                'tracks' => [
                    ['name' => '', 'mix' => '']
                ],
                'index' => $request->index + 1
            ])->render()
        ]);
    }

}
