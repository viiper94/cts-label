<?php

namespace App\Http\Controllers;

use App\EmailingContact;
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
            'email' => 'email|max:190|unique:webinar_contacts,email',
            'additional' => 'string|nullable|max:500',
        ]);
        $contact = new GuestlistContact();
        $contact->fill($request->post());
        if($contact->save()){
            $emailing_contact = EmailingContact::whereEmail($contact->email)->first();
            if(!$emailing_contact){
                $emailing_contact = EmailingContact::create([
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
