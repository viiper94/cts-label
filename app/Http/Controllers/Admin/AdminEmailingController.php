<?php

namespace App\Http\Controllers\Admin;

use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminEmailingController extends Controller{

    public function channels(){
        return view('admin.emailing.index', [
            'channels' => EmailingChannel::with(['subscribers', 'queue' => function($query){
                $query->whereSent('0');
            }])->get(),
            'contacts_count' => EmailingContact::count(),
            'queue_count' => EmailingQueue::count(),
            'queue_sent' => EmailingQueue::whereSent('1')->count(),
            'view' => 'channels'
        ]);
    }

    public function contacts(Request $request){
        if($request->input('channel')){
            $channel = EmailingChannel::findOrFail($request->input('channel'));
            $contacts = $channel->subscribers()->with('channels');
        }else{
            $contacts = EmailingContact::with('channels');
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
        return view('admin.emailing.index', [
            'channels' => EmailingChannel::all(),
            'contacts_count' => EmailingContact::count(),
            'contacts' => $contacts->paginate(100),
            'queue_count' => EmailingQueue::count(),
            'queue_sent' => EmailingQueue::whereSent('1')->count(),
            'view' => 'contacts',
            'sort' => $request->input('sort'),
            'dir' => $request->input('dir'),
            'selected_channel' => isset($channel) ? $channel->title : null
        ]);
    }

    public function queue(){
        return view('admin.emailing.index', [
            'channels' => EmailingChannel::all(),
            'contacts_count' => EmailingContact::count(),
            'queue' => EmailingQueue::orderBy('sent')->orderBy('sort', 'asc')->paginate(100),
            'queue_count' => EmailingQueue::count(),
            'queue_sent' => EmailingQueue::whereSent('1')->count(),
            'view' => 'queue'
        ]);
    }

    public function editChannel(Request $request, $id = null){
        $channel = $id ? EmailingChannel::findOrFail($id) : new EmailingChannel();
        if($request->post()){
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'nullable|string',
                'from' => 'required|string',
                'subject' => 'required|string',
                'template' => 'nullable|string',
                'lang' => 'required|string',
            ]);
            $channel->fill($request->post());
            if($channel->save()){
                if(!$id && $request->post('add_all') === 'on'){
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
            redirect()->route('emailing.channels')->with(['success' => 'Удалено!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function deleteContact(Request $request, $id){
        return EmailingContact::findOrFail($id)->delete() ?
            redirect()->route('emailing.contacts')->with(['success' => 'Удалено!']) :
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
                return redirect()->route('emailing.contacts')->with(['success' => 'Готово!']);
            }else{
                return redirect()->back()->withErrors(['Возникла ошибка =(']);
            }
        }
        return view('admin.emailing.edit_contacts', [
            'contact' => $contact,
            'channels' => EmailingChannel::all(),
        ]);
    }

    public function stop(Request $request){
        if($request->post()){
            $this->validate($request, ['id' => 'required|numeric']);
            return EmailingQueue::whereSent('0')->where('channel_id', $request->post('id'))->delete() ?
                redirect()->route('emailing.channels')->with(['success' => 'Рассылка остановлена!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return abort(403);
    }

    public function start(Request $request){
        if($request->post()){
            $this->validate($request, ['id' => 'required|numeric']);
            $channel = EmailingChannel::with('subscribers')->findOrFail($request->post('id'));
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
            redirect()->route('emailing.queue')->with(['success' => 'Очередь очищена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

}
