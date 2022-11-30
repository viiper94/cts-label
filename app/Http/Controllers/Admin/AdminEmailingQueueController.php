<?php

namespace App\Http\Controllers\Admin;

use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use App\Http\Controllers\Controller;

class AdminEmailingQueueController extends Controller{

    public function index(){
        return view('admin.emailing.queue', [
            'channels' => EmailingChannel::all(),
            'queue' => EmailingQueue::with('channel')->orderBy('sent')->orderBy('sort')->paginate(100),
        ]);
    }

    public function clear(){
        return EmailingQueue::whereSent('1')->delete() !== false ?
            redirect()->route('emailing.queue.index')->with(['success' => 'Очередь очищена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }
}
