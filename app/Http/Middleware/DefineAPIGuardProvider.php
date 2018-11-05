<?php

namespace App\Http\Middleware;

use Closure;

class DefineAPIGuardProvider
{
    public function handle($request, Closure $next, $provider = 'users')
    {
        config(['auth.guards.api.provider' => $provider]);
        return $next($request);
    }
}
