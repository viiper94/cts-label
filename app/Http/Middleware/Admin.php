<?php

namespace App\Http\Middleware;

use App\Cv;
use App\EmailingQueue;
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

        View::share('cv_count', Cv::where('status', 0)->count());
        View::share('queue_count', EmailingQueue::count());
        View::share('queue_sent', EmailingQueue::whereSent('1')->count());

        return $next($request);
    }
}
