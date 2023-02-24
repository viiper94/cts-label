<?php

namespace App\Http\Controllers\Admin;

use App\EmailingChannel;
use App\EmailingContact;
use App\EmailingQueue;
use App\Feedback;
use App\FeedbackResult;
use App\FeedbackTrack;
use App\Http\Controllers\Controller;
use App\Mail\Emailing;
use App\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminFeedbackController extends Controller{

    public function index(Request $request){
        $feedback = Feedback::with('release')->withCount('ftracks', 'results');
        if($request->input('q')) $feedback->where('feedback_title', 'like', '%'.$request->input('q').'%');
        return view('admin.feedback.index', [
            'feedback_list' => $feedback->latest()->paginate(20),
            'releases_without_feedback' => Release::with('feedback')->doesntHave('feedback')
                ->orderBy('sort_id', 'desc')->get()
        ]);
    }

    public function create(Release $release = null){
        $feedback = new Feedback();
        if($release){
            $feedback->release_id = $release->id;
            $feedback->feedback_title = $release->title;
            $feedback->release = $release;
            $feedback->release->load('tracks');
        }
        $feedback->ftracks = [new FeedbackTrack()];
        return view('admin.feedback.edit', [
            'feedback' => $feedback,
            'feedback_list' => Feedback::orderBy('release_id', 'desc')->get(),
            'emailing_channels' => EmailingChannel::withCount('subscribers')->get()
        ]);
    }

    public function store(Request $request, Release $release = null){
        $feedback = new Feedback();
        $this->validate($request, [
            'feedback_title' => 'string|required',
            'image' => 'file|image|dimensions:max_width=2000,max_height=2000|max:5500|mimes:jpeg,png|nullable',
            'tracks' => 'array|required'
        ]);
        $feedback->release_id = $release?->id;
        $feedback->fill($request->post());
        $feedback->slug = Str::slug($feedback->feedback_title);
        $feedback->sort_id = $feedback->getLatestSortId(Feedback::class);
        if(!$release && $request->hasFile('image')){
            $image = $request->file('image');
            $feedback->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/feedback'), $feedback->image);
        }
        if($feedback->save()){
            $feedback->saveTracks($request, new: true);
            $feedback->archive_name = $feedback->archiveTracks();
            $feedback->related()->sync($request->post('related'));
            return $feedback->save() ?
                redirect()->route('feedback.index')->with(['success' => 'Фидбэк успешно добавлен!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }
        return redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function edit(Feedback $feedback){
        $feedback->load(['related', 'ftracks' => function($query){
            $query->with('feedback');
        }]);
        return view('admin.feedback.edit', [
            'feedback' => $feedback,
            'feedback_list' => Feedback::orderBy('release_id', 'desc')->get(),
            'emailing_channels' => EmailingChannel::withCount('subscribers')->get()
        ]);
    }

    public function update(Request $request, Feedback $feedback){
        $this->validate($request, [
            'feedback_title' => 'string|required',
            'tracks' => 'array|required'
        ]);
        $feedback->fill($request->post());
        $feedback->saveTracks($request);
        $feedback->archive_name = $feedback->archiveTracks();
        $feedback->related()->sync($request->post('related'));
        if($request->hasFile('image')){
            // delete old image
            $path = public_path('images/feedback/').$feedback->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
            // upload new image
            $image = $request->file('image');
            $feedback->image = md5($image->getClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/feedback'), $feedback->image);
        }
        return $feedback->save() ?
            redirect()->route('feedback.index')->with(['success' => 'Фидбэк успешно отредактирован!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroy(Feedback $feedback){
        $feedback->related()->detach();
        if($feedback->ftracks){
            // delete audio files
            $path = public_path('audio/feedback/'.$feedback->slug);
            if(is_dir($path)){
                $this->rrmdir($path);
            }
        }
        if($feedback->image && is_file(public_path('images/feedback/'.$feedback->image))){
            unlink(public_path('images/feedback/'.$feedback->image));
        }
        return $feedback->delete() ?
            redirect()->route('feedback.index')->with(['success' => 'Фидбэк успешно удалён!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function destroyTrack(Request $request, FeedbackTrack $track){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'status' => $track->delete() ? 'OK' : 'Error'
        ]);
    }

    public function destroyResult(FeedbackResult $result){
        return $result->delete() ?
            redirect()->back()->with(['success' => 'Успешно удалёно!']) :
            redirect()->back()->withErrors(['Возникла ошибка =(']);
    }

    public function getTemplate(Request $request){
        if(!$request->ajax()) abort(404);
        return response()->json([
            'html' => view('admin.feedback.track_item', [
                'key' => $request->index,
                'track' => new FeedbackTrack(),
                'feedback' => new Feedback()
            ])->render()
        ]);
    }

    public function emailing(Request $request){
        if($request->post()){
            $this->validate($request, ['channels' => 'required|array']);
            $contacts = EmailingContact::with(['channels' => function($query) use ($request){
                $query->whereIn('id', $request->channels);
            }]);
            foreach($request->channels as $id){
                $contacts = $contacts->orWhereRelation('channels', 'id', $id);
            }
            $contacts = $contacts->get();
            foreach($contacts as $contact){
                $mail = EmailingQueue::create([
                    'channel_id' => $contact->channels[0]->id,
                    'unsubscribe' => true,
                    'template' => 'feedback',
                    'feedback_id' => $request->id,
                    'subject' => $contact->channels[0]->subject,
                    'from' => $contact->channels[0]->from ?? env('EMAIL_FROM'),
                    'name' => $contact->name,
                    'to' => $contact->email,
                ]);
//                    Mail::to($contact->email)->send(new Emailing($mail)); // for test only
            }
            return redirect()->back()->with(['success' => 'Рассылка запущена!']);
        }
        abort(403);
    }

    public function peaks(Request $request){
        if(!$request->ajax()) abort(404);
        $track = FeedbackTrack::findOrFail($request->track);
        $track->peaks = $request->peaks;
        $track->save();
        return response()->json(['status'=>'ok']);
    }

}
