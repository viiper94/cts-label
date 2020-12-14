<?php

namespace App\Http\Middleware;

use Closure;
use Gate;
use App;
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
        App::setLocale('ru');

        $cv = App\Cv::where('status', 0)->count();
        View::share('cv_count', $cv);

        return $next($request);
    }
}
