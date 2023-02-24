<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use Illuminate\Http\Request;

class AdminEmailingChannelsController extends Controller{

    public function index(){
        return view('admin.emailing.channels', [
            'channels' => EmailingChannel::withCount(['subscribers', 'queue' => function($query){
                $query->whereSent('0');
            }])->get()
        ]);
    }

    public function create(){
        return view('admin.emailing.edit_channels', [
            'channel' => new EmailingChannel()
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'from' => 'required|string',
            'subject' => 'required|string',
            'template' => 'nullable|string',
            'lang' => 'required|string',
        ]);
        $channel = new EmailingChannel();
        $channel->fill($request->post());
        if($channel->save()){
            if($request->post('add_all') === 'on'){
                $contacts = EmailingContact::pluck('id')->toArray();
                $channel->subscribers()->attach($contacts);
            }
            return redirect()->route('emailing.channels.index')->with(['success' => 'Готово!']);
        }else return redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function edit(EmailingChannel $channel){
        return view('admin.emailing.edit_channels', [
            'channel' => $channel
        ]);
    }

    public function update(Request $request, EmailingChannel $channel){
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'from' => 'required|string',
            'subject' => 'required|string',
            'template' => 'nullable|string',
            'lang' => 'required|string',
        ]);
        $channel->fill($request->post());
        return $channel->save()
            ? redirect()->route('emailing.channels.index')->with(['success' => 'Готово!'])
            : redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy($id){
        return EmailingChannel::findOrFail($id)->delete()
            ? redirect()->route('emailing.channels.index')->with(['success' => 'Удалено!'])
            : redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function stop(Request $request){
        if($request->post()){
            $this->validate($request, ['id' => 'required|numeric']);
            return EmailingQueue::whereSent('0')->where('channel_id', $request->post('id'))->delete() ?
                redirect()->route('emailing.channels.index')->with(['success' => 'Рассылка остановлена!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        abort(403);
    }

    public function start(Request $request){
        if($request->post()){
            $this->validate($request, ['id' => 'required|numeric']);
            $channel = EmailingChannel::with('subscribers')->findOrFail($request->post('id'));
            foreach($channel->subscribers as $contact){
                EmailingQueue::create([
                    'channel_id' => $channel->id,
                    'data' => [
                        'unsubscribe' => true,
                        'template' => 'custom'
                    ],
                    'subject' => $channel->subject,
                    'from' => $channel->from ?? env('EMAIL_FROM'),
                    'name' => $contact->name,
                    'to' => $contact->email,
                ]);
            }
            return redirect()->back()->with(['success' => 'Рассылка запущена!']);
        }
        abort(403);
    }

    public function startTest(Request $request){
        $this->validate($request, ['channel' => 'required|numeric']);
        $channel = EmailingChannel::findOrFail($request->channel);
        foreach($request->test_emails as $name => $email){
            EmailingQueue::create([
                'channel_id' => $channel->id,
                'data' => [
                    'unsubscribe' => true,
                    'template' => 'custom'
                ],
                'subject' => $channel->subject,
                'from' => $channel->from ?? env('EMAIL_FROM'),
                'name' => $name,
                'to' => $email,
            ]);
        }
        return redirect()->back()->with(['success' => 'Тестовая рассылка запущена!']);
    }

}
