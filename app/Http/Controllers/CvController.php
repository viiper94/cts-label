<?php

namespace App\Http\Controllers;

use App\Cv;
use App\Mail\CvMail;
use App\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CvController extends Controller{

    public function index(Request $request){
        if($request->post()){
            $this->validate($request, [
                'name' => 'required|string|max:190',
                'email' => 'required|email|max:190',
                'birth_date' => 'required|date_format:Y-m-d',
                'dj_name' => 'nullable|string|max:190',
                'vk' => 'nullable|url|max:190',
                'facebook' => 'nullable|url|max:190',
                'soundcloud' => 'nullable|url|max:190',
                'other_social' => 'nullable|url|max:190',
                'phone_number' => 'required|string|max:190',
                'address' => 'required|string',
                'education' => 'required|string',
                'job' => 'required|string',
                'sound_engineer_skills' => 'nullable|string',
                'sound_producer_skills' => 'nullable|string',
                'dj_skills' => 'nullable|string',
                'music_genres' => 'nullable|string',
                'os' => 'nullable|string',
                'equipment' => 'nullable|string',
                'additional_info' => 'nullable|string',
                'learned_about_ctschool' => 'required|string',
                'course' => 'required|string',
                'what_to_learn' => 'nullable|string',
                'purpose_of_learning' => 'nullable|string',
            ]);
            $cv = new Cv();
            $cv->fill($request->post());
            $cv->user_id = Auth::check() ? Auth::user()->id : null;
            $cv->birth_date = Carbon::parse($request->post('birth_date'))->format('Y-m-d');
            if($cv->save()){
                $cv->document = $cv->createDocument();
                Mail::to(env('ADMIN_EMAIL'))->send(new CvMail($cv));
                $cv->update();
                return redirect()->route('home')->with(['success' => trans('cv.end_msg')]);
            }else{
                return redirect()->back()->withErrors([trans('cv.error_msg')]);
            }
        }
        return view('cv.index', [
            'user' => Auth::user(),
            'courses' => School::where([
                'category' => 'courses',
                'lang' => App::getLocale()
            ])->get()
        ]);
    }

}
