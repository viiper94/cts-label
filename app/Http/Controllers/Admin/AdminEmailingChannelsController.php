<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmailingChannelExport;
use App\Http\Controllers\Controller;
use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;

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
            'title' => 'required|string|max:191',
            'description' => 'nullable|string|max:191',
            'from' => 'required|email|max:191',
            'from_name' => 'required|string|max:191',
            'subject' => 'required|string|max:191',
            'template' => 'nullable|string|max:191',
            'lang' => 'required|string|max:191',
            'smtp_host' => 'nullable|string|max:191',
            'smtp_port' => 'nullable|required_unless:smtp_host,null|numeric',
            'smtp_username' => 'nullable|string|required_unless:smtp_host,null|max:191',
            'smtp_password' => 'nullable|string|required_unless:smtp_host,null|max:191',
            'smtp_encryption' => 'nullable|string|required_unless:smtp_host,null|max:191',
        ]);
        $channel = new EmailingChannel();
        $channel->fill($request->post());
        if($channel->save()){
            if($request->post('add_all')){
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
            'title' => 'required|string|max:191',
            'description' => 'nullable|string|max:191',
            'from' => 'required|email|max:191',
            'from_name' => 'required|string|max:191',
            'subject' => 'required|string|max:191',
            'template' => 'nullable|string|max:191',
            'lang' => 'required|string|max:191',
            'smtp_host' => 'nullable|string|max:191',
            'smtp_port' => 'nullable|required_unless:smtp_host,null|numeric',
            'smtp_username' => 'nullable|string|required_unless:smtp_host,null|max:191',
            'smtp_password' => 'nullable|string|required_unless:smtp_host,null|max:191',
            'smtp_encryption' => 'nullable|string|required_unless:smtp_host,null|max:191',
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
                    'template' => $channel->template ?? 'custom',
                    'subject' => $channel->subject,
                    'from' => $channel->from ?? env('EMAIL_FROM'),
                    'from_name' => $channel->from_name ?? env('APP_NAME'),
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
                'template' => $channel->template ?? 'custom',
                'subject' => $channel->subject,
                'from_name' => $channel->from_name ?? env('APP_NAME'),
                'from' => $channel->from ?? env('EMAIL_FROM'),
                'name' => $name,
                'to' => $email,
                'smtp_host' => $channel->smtp_host,
                'smtp_port' => $channel->smtp_port,
                'smtp_username' => $channel->smtp_username,
                'smtp_password' => $channel->smtp_password,
                'smtp_encryption' => $channel->smtp_encryption,
            ]);
        }
        return redirect()->back()->with(['success' => trans('emailing.channels.test_emailing_started')]);
    }

    public function export(EmailingChannel $channel){
        try{
            $channel->load('subscribers');
            $file_name = Str::slug($channel->title).'.xlsx';
            return (new EmailingChannelExport($channel->subscribers))->download(
                $file_name,
                Excel::XLSX,
                ['Content-Type' => 'text/xlsx']
            );

        }catch(\Exception $e){
            return redirect()->back()->withErrors([trans('alert.error') => $e->getMessage()]);
        }
    }

}
