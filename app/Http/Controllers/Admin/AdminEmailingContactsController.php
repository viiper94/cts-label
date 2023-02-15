<?php

namespace App\Http\Controllers\Admin;

use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminEmailingContactsController extends Controller{

    public function index(Request $request){
        if($request->input('channel')){
            $channel = EmailingChannel::findOrFail($request->input('channel'));
            $contacts = $channel->subscribers()->with('channels');
        }else{
            $contacts = EmailingContact::with('channels:title');
        }
        if($request->input('q')){
            $contacts = $contacts->where('name', 'like', '%'.$request->input('q').'%')
                ->orWhere('full_name', 'like', '%'.$request->input('q').'%')
                ->orWhere('email', 'like', '%'.$request->input('q').'%')
                ->orWhere('position', 'like', '%'.$request->input('q').'%')
                ->orWhere('company', 'like', '%'.$request->input('q').'%');
        }
        if($request->input('sort')){
            $contacts = $contacts->orderBy($request->input('sort'), ($request->input('dir') === 'down') ? 'desc' : 'asc');
        }
        return view('admin.emailing.contacts', [
            'channels' => EmailingChannel::all(),
            'contacts_count' => EmailingContact::count(),
            'contacts' => $contacts->paginate(100)->onEachSide(1),
            'sort' => $request->input('sort'),
            'dir' => $request->input('dir'),
            'selected_channel' => isset($channel) ? $channel->title : null
        ]);
    }

    public function create(){
        return view('admin.emailing.edit_contacts', [
            'contact' => new EmailingContact(),
            'channels' => EmailingChannel::all(),
        ]);
    }

    public function store(Request $request){
        $contact = new EmailingContact();
        $this->validate($request, [
            'email' => 'required|email|unique:App\EmailingContact',
            'name' => 'required|string',
            'full_name' => 'nullable|string',
            'company' => 'nullable|string',
            'company_foa' => 'nullable|string',
            'position' => 'nullable|string',
            'website' => 'nullable|url',
            'country' => 'nullable|string',
            'phone' => 'nullable|string',
            'additional' => 'nullable|string',
            'channels' => 'nullable|array'
        ]);
        $contact->fill($request->post());
        if($contact->save()){
            $contact->channels()->sync($request->input('channels'));
            return redirect()->route('emailing.contacts.index')->with(['success' => 'Готово!']);
        }else{
            return redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
    }

    public function edit(EmailingContact $contact){
        return view('admin.emailing.edit_contacts', [
            'contact' => $contact,
            'channels' => EmailingChannel::all(),
        ]);
    }

    public function update(Request $request, EmailingContact $contact){
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required|string',
            'full_name' => 'nullable|string',
            'company' => 'nullable|string',
            'company_foa' => 'nullable|string',
            'position' => 'nullable|string',
            'website' => 'nullable|url',
            'country' => 'nullable|string',
            'phone' => 'nullable|string',
            'additional' => 'nullable|string',
            'channels' => 'nullable|array'
        ]);
        $contact->fill($request->post());
        if($contact->save()){
            $contact->channels()->sync($request->input('channels'));
            return redirect()->route('emailing.contacts.index')->with(['success' => 'Готово!']);
        }else{
            return redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
    }

    public function destroy(EmailingContact $contact){
        return $contact->delete() ?
            redirect()->route('emailing.contacts.index')->with(['success' => 'Удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

//    public function import(){
//        $file_name = 'CTSchool-full_info-2023.csv';
////        $file_name = 'BTU-all-2010-15-update-2023.csv';
//        $content = @fopen(resource_path($file_name), "r");
//        while(($row = fgetcsv($content, 1000, ";", )) !== FALSE){
////            dd($row);
////            $site = trim($row[6]);
////            if(strlen($site) > 0 && stristr($site, 'http') === false) $site = 'http://'.$site;
//            $contact = \App\EmailingContact::create([
////                'company' => $row[0],
//                'email' => $row[0],
//                'name' => $row[1],
////                'full_name' => $row[3],
////                'position' => $row[4],
////                'company_foa' => $row[5],
////                'website' => $site,
////                'country' => $row[7],
//                'phone' => $row[2],
//            ]);
//            $contact->channels()->attach(13);
//        }
//        fclose($content);
//    }

}
