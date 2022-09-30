<?php

namespace App\Http\Controllers\Admin;

use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Emailing;

class AdminEmailingController extends Controller{

    public function index(){
        return view('admin.emailing.index', [
            'channels' => EmailingChannel::with('subscribers')->get(),
            'contacts' => EmailingContact::with('channels')->get(),
            'queue' => EmailingQueue::all(),
            'queue_sent' => EmailingQueue::whereSent('1')->orderBy('sent')->get()
        ]);
    }

    public function editChannel(Request $request, $id = null){
        $channel = $id ? EmailingChannel::findOrFail($id) : new EmailingChannel();
        if($request->post()){
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'nullable|string',
                'from' => 'nullable|string',
                'subject' => 'required|string',
                'template' => 'nullable|string',
                'lang' => 'required|string',
            ]);
            $channel->fill($request->post());
            if($channel->save()){
                if(!$id){
                    $contacts = EmailingContact::pluck('id')->toArray();
                    $channel->subscribers()->attach($contacts);
                }
                return redirect()->route('emailing_admin')->with(['success' => 'Готово!']);
            }else

            return redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return view('admin.emailing.edit_channels', [
            'channel' => $channel
        ]);
    }

    public function deleteChannel(Request $request, $id){
        return EmailingChannel::findOrFail($id)->delete() ?
            redirect()->back()->with(['success' => 'Удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function deleteContact(Request $request, $id){
        return EmailingContact::findOrFail($id)->delete() ?
            redirect()->back()->with(['success' => 'Удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function editContact(Request $request, $id = null){
        $contact = $id ? EmailingContact::findOrFail($id) : new EmailingContact();
        if($request->post()){
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
                return redirect()->route('emailing_admin')->with(['success' => 'Готово!']);
            }else{
                return redirect()->back()->withErrors(['Возникла ошибка =(']);
            }
        }
        return view('admin.emailing.edit_contacts', [
            'contact' => $contact,
            'channels' => EmailingChannel::all(),
        ]);
    }

    public function start(Request $request){
        if($request->post()){
            $this->validate($request, ['id' => 'required|numeric']);
            $channel = EmailingChannel::findOrFail($request->post('id'));
            foreach($channel->subscribers as $contact){
                $mail = EmailingQueue::create([
                    'channel_id' => $channel->id,
                    'subject' => $channel->subject,
                    'from' => $channel->from ?? env('EMAIL_FROM'),
                    'name' => $contact->name,
                    'to' => $contact->email,
                ]);
//                Mail::to($contact->email)->send(new Emailing($mail)); // for test only
            }
            return redirect()->back()->with(['success' => 'Рассылка запущена!']);
        }
        return abort(403);
    }

    public function clearQueue(){
        return EmailingQueue::whereSent('1')->delete() ?
            redirect()->back()->with(['success' => 'Очередь очищена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

}
