<?php

namespace App\Http\Controllers;

use App\EmailingContact;
use App\Mail\WebinarMail;
use App\WebinarContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebinarContactController extends Controller{

    public function index(){
        app()->setLocale('ua');
        return view('event.index');
    }

    public function store(Request $request){
        app()->setLocale('ua');
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
                    'position' => $contact->type === 'інше' ? $contact->other : $contact->type
                ]);
            }
            $emailing_contact->channels()->attach(12);

            Mail::to($contact->email)->send(new WebinarMail($contact));

            return redirect()->route('event')->with(['success' => 'Ви успішно зарееструвались на вебінар!']);
        }else{
            return redirect()->back()->withErrors(['Виникла помилка, спробуйте трохи пізніше =(']);
        }
    }

}
