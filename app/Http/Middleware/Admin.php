<?php

namespace App\Http\Middleware;

use App\ArtistCv;
use App\Cv;
use App\EmailingQueue;
use App\FeedbackResult;
use Closure;
use Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(Auth::guest()) return redirect('login');
        if(Gate::denies('admin')) abort(403);

        View::share('feedback_results_count', FeedbackResult::where('status', 0)->count());
        View::share('artists_cv_count', ArtistCv::where('status', 0)->count());
        View::share('school_cv_count', Cv::where('status', 0)->count());
        View::share('queue_count', EmailingQueue::count());
        View::share('queue_sent', EmailingQueue::whereSent('1')->count());

        return $next($request);
    }
}
