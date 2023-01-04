<?php

namespace App\Http\Controllers;

use App\Mail\CallbackMail;
use App\School;
use App\StudioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class AppController extends Controller{

    public function about(){
        return view('about');
    }

    public function ctschool(){
        return view('school', [
            'teachers' => School::where(['category' => 'teachers', 'lang' => App::getLocale()])->orderBy('sort_id')->get(),
            'courses' => School::where(['category' => 'courses', 'lang' => App::getLocale()])->orderBy('sort_id')->get(),
            'prices' => [],
            'subject' => [],
        ]);
    }

    public function studio(Request $request){
        if($request->ajax()){
            return response()->json(['OK']);
        }
        $services = StudioService::where('visible', 1);
        if(StudioService::where(['visible' => 1, 'lang' => App::getLocale()])->count() > 0){
            $services = $services->where('lang', App::getLocale());
        }else{
            $services = $services->where('lang', 'en');
        }
        return view('studio', [
            'services' => $services->orderBy('sort_id')->get()
        ]);
    }

    public function sendCallback(Request $request){
        $this->validate($request, [
            'service' => 'string|required',
            'name' => 'string|required',
            'tel' => 'string|nullable',
            'email' => 'email|required:tel'
        ]);
        try{
            Mail::to(env('ADMIN_EMAIL'))->send(new CallbackMail(
                data: [
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'target' => $request->target,
                    'service' => $request->service,
                ]
            ));
        }catch(\Exception $e){
//            dd($e);
            return redirect()->back()->withErrors('Возникла ошибка =(');
        }
        return redirect()->back()->with(['success' => 'Запрос успешно отправлен!']);
    }

}
