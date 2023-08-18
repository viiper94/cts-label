<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;

class I18n{

    public $defaultLang = 'ua';

    public function handle($request, Closure $next){
        App::setLocale($_COOKIE['lang'] ?? $this->defaultLang);
        Carbon::setLocale(str_replace('ua', 'uk', app()->getLocale()));
        return $next($request);
    }
}
