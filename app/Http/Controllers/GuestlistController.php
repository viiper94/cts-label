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
        $this->validate($request, [
            'name' => 'string|required|max:190',
            'email' => 'email|max:190|unique:guestlist,email',
            'company' => 'string|nullable|max:190',
        ]);
        $contact = new GuestlistContact();
        $contact->fill($request->post());
        if($contact->save()){
            $emailing_contact = GuestlistContact::whereEmail($contact->email)->first();
            if(!$emailing_contact){
                $emailing_contact = GuestlistContact::create([
                    'email' => $contact->email,
                    'name' => $contact->name
                ]);
            }
            $emailing_contact->channels()->attach(12);

//            Mail::to($contact->email)->send(new WebinarMail($contact));

            return redirect()->route('event')->with(['success' => 'Ви успішно зареєструвались на вебінар!']);
        }else{
            return redirect()->back()->withErrors(['Виникла помилка, спробуйте трохи пізніше =(']);
        }
    }

}
