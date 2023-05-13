<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->cookie('lang', 'ru');

        if(!$lang && !in_array($lang, ['tm', 'ru'])) {
            $lang = 'ru';
        }

        app()->setLocale($lang);

        return $next($request);
    }
}
