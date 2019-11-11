<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class I18n{

    public $defaultLang = 'en';

    public function handle($request, Closure $next){
        App::setLocale($_COOKIE['lang'] ?? $this->defaultLang);
        return $next($request);
    }
}