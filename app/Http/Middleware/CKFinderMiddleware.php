<?php

namespace App\Http\Middleware;

use Closure;

class CKFinderMiddleware
{
    public function handle($request, Closure $next)
    {
        config(['ckfinder.authentication' => function() use ($request) {
            return true;
        }] );

        return $next($request);
    }
}
