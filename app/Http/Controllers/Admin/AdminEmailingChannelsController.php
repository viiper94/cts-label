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
            'from' => 'required|email',
            'from_name' => 'required|string',
            'subject' => 'required|string',
            'template' => 'nullable|string',
            'lang' => 'required|string',
            'smtp_host' => 'nullable|string',
            'smtp_port' => 'numeric|required_if:smtp_host',
            'smtp_username' => 'string|required_if:smtp_host',
            'smtp_password' => 'string|required_if:smtp_host',
            'smtp_encryption' => 'string|required_if:smtp_host',
        ]);
        $channel = new EmailingChannel();
        $channel->fill($request->post());
        if($channel->save()){
            if($request->post('add_all') === 'on'){
                $contacts = EmailingContact::pluck('id')->toArray();
                $channel->subscribers()->attach($contacts);
            }
            return redirect()->route('emailing.channels.index')->with(['success' => trans('emailing.channels.channel_added')]);
        }else return redirect()->back()->withErrors([trans('alert.error')]);
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
            'from' => 'required|email',
            'from_name' => 'required|string',
            'subject' => 'required|string',
            'template' => 'nullable|string',
            'lang' => 'required|string',
            'smtp_host' => 'nullable|string',
            'smtp_port' => 'required_with:smtp_host|nullable|numeric',
            'smtp_username' => 'required_with:smtp_host|nullable|string',
            'smtp_password' => 'required_with:smtp_host|nullable|string',
            'smtp_encryption' => 'required_with:smtp_host|nullable|string',
        ]);
        $channel->fill($request->post());
        return $channel->save()
            ? redirect()->route('emailing.channels.index')->with(['success' => trans('emailing.channels.channel_edited')])
            : redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function destroy($id){
        return EmailingChannel::findOrFail($id)->delete()
            ? redirect()->route('emailing.channels.index')->with(['success' => trans('emailing.channels.channel_deleted')])
            : redirect()->back()->withErrors([trans('alert.error')]);
    }

    public function stop(Request $request){
        if($request->post()){
            $this->validate($request, ['id' => 'required|numeric']);
            return EmailingQueue::whereSent('0')->where('channel_id', $request->post('id'))->delete() ?
                redirect()->route('emailing.channels.index')->with(['success' => trans('emailing.channels.emailing_stopped')]) :
                redirect()->back()->withErrors([trans('alert.error')]);
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
                    'unsubscribe' => $channel->unsubscribe,
                    'template' => $channel->template ?? 'custom_ade',
                    'subject' => $channel->subject,
                    'from' => $channel->from,
                    'from_name' => $channel->from_name,
                    'name' => $contact->name,
                    'to' => $contact->email,
                    'smtp_host' => $channel->smtp_host,
                    'smtp_port' => $channel->smtp_port,
                    'smtp_username' => $channel->smtp_username,
                    'smtp_password' => $channel->smtp_password,
                    'smtp_encryption' => $channel->smtp_encryption,
                ]);
            }
            return redirect()->back()->with(['success' => trans('emailing.channels.emailing_started')]);
        }
        abort(403);
    }

    public function startTest(Request $request){
        $this->validate($request, ['channel' => 'required|numeric']);
        $channel = EmailingChannel::findOrFail($request->channel);
        foreach($request->test_emails as $name => $email){
            EmailingQueue::create([
                'channel_id' => $channel->id,
                'unsubscribe' => $channel->unsubscribe,
                'template' => $channel->template ?? 'custom_ade_prohor',
                'subject' => $channel->subject,
                'from' => $channel->from ?? env('EMAIL_FROM'),
                'name' => $name,
                'to' => $email,
            ]);
        }
        return redirect()->back()->with(['success' => trans('emailing.channels.test_emailing_started')]);
    }

}
