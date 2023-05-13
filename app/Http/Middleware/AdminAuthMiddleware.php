<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!currentStaff()) {
            return redirect()->route('auth.login.page');
        }

        return $next($request);
    }
}
