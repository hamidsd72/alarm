<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRole('مدیر') || auth()->user()->hasRole('مدیر ارشد')) {
            return $next($request);
        }
        abort('401');
    }
}