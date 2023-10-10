<?php

namespace App\Http\Controllers;

use App\GuestlistContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GuestlistController extends Controller{

    public function index(){
        return view('guestlist');
    }

    public function store(Request $request){
        app()->setLocale('en');
        $this->validate($request, [
            'name' => 'string|required|max:190',
            'email' => 'email|max:190|nullable|unique:guestlist,email',
            'company' => 'string|nullable|max:190',
        ]);
        $contact = new GuestlistContact();
        $contact->fill($request->post());
        return $contact->save() ?
            redirect()->route('home')->with(['success' => 'You have been successfully to event guest list!']) :
            redirect()->back()->withErrors(['An error occurred, please try later =(']);
    }

}
