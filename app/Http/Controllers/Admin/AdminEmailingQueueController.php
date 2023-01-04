<?php

namespace App\Http\Controllers\Admin;

use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminEmailingQueueController extends Controller{

    public function index(Request $request){
        $queue = EmailingQueue::with('channel');
        if($request->input('q')){
            $queue = $queue->where('name', 'like', '%'.$request->input('q').'%')
                ->orWhere('to', 'like', '%'.$request->input('q').'%');
        }
        return view('admin.emailing.queue', [
            'channels' => EmailingChannel::all(),
            'queue' => $queue->orderBy('sent')->orderBy('sort')->paginate(100),
        ]);
    }

    public function clear(){
        return EmailingQueue::whereSent('1')->delete() !== false ?
            redirect()->route('emailing.queue.index')->with(['success' => 'Очередь очищена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }
}
