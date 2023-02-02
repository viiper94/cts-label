<?php

namespace App\Http\Controllers;

use App\EmailingContact;
use App\WebinarContact;
use Illuminate\Http\Request;

class WebinarContactController extends Controller{

    public function index(){
        return view('event.index');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'string|required|max:190',
            'email' => 'email|required|max:190',
            'tel' => 'string|required|max:190',
            'type' => 'string|required',
            'other' => 'string|required_if:type,інше|nullable|max:190',
            'additional' => 'string|nullable|max:500',
        ]);
        $contact = new WebinarContact();
        $contact->fill($request->post());
        if($contact->save()){
            $emailing_contact = EmailingContact::whereEmail($contact->email)->first();
            if(!$emailing_contact){
                $emailing_contact = EmailingContact::create([
                    'email' => $contact->email,
                    'name' => $contact->name,
                ]);
            }
            $emailing_contact->channels()->attach(12);
            return redirect()->route('event')->with(['success' => 'Ви успішно зарееструвались на вебінар!']);
        }else{
            return redirect()->back()->withErrors(['Виникла помилка, спробуйте трохи пізніше =(']);
        }
    }

}
