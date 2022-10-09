<?php

namespace App\Http\Controllers\Admin;

use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use App\Http\Controllers\Controller;

class AdminEmailingQueueController extends Controller{

    public function index(){
        return view('admin.emailing.index', [
            'channels' => EmailingChannel::all(),
            'contacts_count' => EmailingContact::count(),
            'queue' => EmailingQueue::orderBy('sent')->orderBy('sort', 'asc')->paginate(100),
            'queue_count' => EmailingQueue::count(),
            'queue_sent' => EmailingQueue::whereSent('1')->count(),
            'view' => 'queue'
        ]);
    }

    public function clear(){
        return EmailingQueue::whereSent('1')->delete() ?
            redirect()->route('queue.index')->with(['success' => 'Очередь очищена!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }
}
