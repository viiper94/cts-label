<?php

namespace App\Http\Controllers;

use App\ArtistContact;
use Illuminate\Http\Request;

class ArtistsContactInfoController extends Controller
{

    public function create(Request $request){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'html' => view('artists.cv.edit', [
                'info' => new \App\ArtistContact()
            ])->render(),
            'locale' => app()->getLocale()
        ]);
    }

    public function store(Request $request){
        if(!$request->ajax()) abort(404);
        $this->validate($request, [
            'artist_name' => 'required|max:190|string',
            'first_name' => 'required|max:190|string',
            'surname' => 'required|max:190|string',
            'publisher' => 'nullable|max:190|string',
            'pro' => 'nullable|max:190|string',
            'date_of_birth' => 'nullable|date_format:Y-m-d|string',
            'address' => 'string|nullable',
            'city' => 'max:190|string|nullable',
            'state' => 'max:190|string|nullable',
            'zip' => 'max:190|string|nullable',
            'country' => 'max:190|string|nullable',
            'phone' => 'max:190|string|nullable',
            'email' => 'email|max:190|nullable',
            'bank' => 'max:190|string|nullable',
            'place_of_bank' => 'string|nullable',
            'account_holder' => 'max:190|string|nullable',
            'account_number' => 'max:190|string|nullable',
            'passport_number' => 'max:190|string|nullable',
        ]);
        $contact = ArtistContact::create($request->post());
        if($contact->id){
            return response()->json([
                'html' => view('artists.cv.artist_contact_item', [
                    'info' => $contact
                ])->render(),
                'id' => $contact->id
            ]);
        }
        return false;
    }

    public function edit(Request $request, ArtistContact $contact){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'html' => view('artists.cv.edit', [
                'info' => $contact
            ])->render(),
            'locale' => app()->getLocale()
        ]);
    }

    public function update(Request $request, ArtistContact $contact){
        if(!$request->ajax()) abort(404);
        $this->validate($request, [
            'artist_name' => 'required|max:190|string',
            'first_name' => 'required|max:190|string',
            'surname' => 'required|max:190|string',
            'publisher' => 'nullable|max:190|string',
            'pro' => 'nullable|max:190|string',
            'date_of_birth' => 'nullable|date_format:Y-m-d|string',
            'address' => 'string|nullable',
            'city' => 'max:190|string|nullable',
            'state' => 'max:190|string|nullable',
            'zip' => 'max:190|string|nullable',
            'country' => 'max:190|string|nullable',
            'phone' => 'max:190|string|nullable',
            'email' => 'email|max:190|nullable',
            'bank' => 'max:190|string|nullable',
            'place_of_bank' => 'string|nullable',
            'account_holder' => 'max:190|string|nullable',
            'account_number' => 'max:190|string|nullable',
            'passport_number' => 'max:190|string|nullable',
        ]);
        $contact->fill($request->post());
        $contact->save();
        return response()->json([
            'html' => view('artists.cv.artist_contact_item', [
                'info' => $contact
            ])->render(),
            'id' => $contact->id
        ]);
    }

}
