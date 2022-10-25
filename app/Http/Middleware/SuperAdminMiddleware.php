<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRole('مدیر ارشد')) {
            return $next($request);
        }
        abort('401');
    }
}