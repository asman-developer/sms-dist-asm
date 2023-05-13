<?php

namespace App\Http\Middleware;

use Closure;

class ClientAuth
{
    public function handle($request, Closure $next)
    {
        if (!$request->token) {
            return response()
                    ->json([
                        'success' => false,
                        'error'   => 'token is required'
                    ], 401);
        }

        if (!isset(config('clients.tokens')[$request->token])){
            return response()
                    ->json([
                        'success' => false,
                        'error'   => 'invalid token'
                    ], 401);
        }

        return $next($request);
    }
}
