<?php

namespace App\Http\Controllers;

use App\Cv;
use App\EmailingChannel;
use App\EmailingContact;
use App\Mail\CvMail;
use App\School;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

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

    public function unsubscribe(Request $request, $hash){
        $complete = false;
        try{
            $decrypted = json_decode(Crypt::decryptString($hash), true);

        }catch (DecryptException $e){
            abort(404);
        }

        $channel = EmailingChannel::whereId($decrypted['channel_id'])->firstOrFail();
        App::setLocale($channel->lang);

        if($request->post()){
            if($request->input('type') === 'all'){
                EmailingContact::whereEmail($decrypted['email'])->delete();
            }else{
                $sub = EmailingContact::whereEmail($decrypted['email'])->firstOrFail();
                $sub->channels()->detach($channel->id);
            }
            $complete = true;
        }

        return view('unsubscribe', [
            'email' => $decrypted['email'],
            'from' => $decrypted['from'],
            'complete' => $complete
        ]);
    }

}
