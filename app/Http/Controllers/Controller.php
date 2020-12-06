<?php

namespace App\Http\Controllers;

use App\Cv;
use App\School;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function rrmdir($src) {
        if(is_dir($src)){
            $dir = opendir($src);
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' )) {
                    $full = $src . '/' . $file;
                    if ( is_dir($full) ) {
                        $this->rrmdir($full);
                    }
                    else {
                        unlink($full);
                    }
                }
            }
            closedir($dir);
            rmdir($src);
        }
    }

    public function cv(Request $request){
        if($request->post()){
            $this->validate($request, [
                'name' => 'required|string|max:190',
                'email' => 'required|email|max:190',
                'birth_date' => 'required|date_format:d F Y',
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
                'music_genres' => 'required|string',
                'additional_info' => 'nullable|string',
                'learned_about_ctschool' => 'required|string',
                'course' => 'required|string',
                'what_to_learn' => 'nullable|string',
                'purpose_of_learning' => 'nullable|string',
            ]);
            $cv = new Cv();
            $cv->fill($request->post());
            $cv->user_id = Auth::user()->id;
            $cv->birth_date = date('Y-m-d', strtotime($cv->birth_date));
            return $cv->save() ?
                redirect()->route('home')->with(['success' => trans('cv.end_msg')]) :
                redirect()->back()->withErrors([trans('cv.error_msg')]);
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
