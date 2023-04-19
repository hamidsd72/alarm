<?php

namespace App\Http\Middleware;

use Closure;

class SpecialUserMiddleware
{
    public function handle($request, Closure $next)
    {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) $user_id = auth()->user()->id;
        else $user_id = auth()->user()->reagent_id;

        $special_user   = true;
        if( auth()->user()->user_status!='active' || !\App\User::is_special_user($user_id) ) $special_user = false;

        if (auth()->user()->hasRole('مدیر ارشد') || $special_user) return $next($request);
        return redirect()->route('user.user-transaction.create');
    }
}