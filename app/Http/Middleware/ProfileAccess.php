<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(( Auth::check() && !$request->id)
          || User::findOrFail($request->id)->hasRole(User::ROLE_TEACHER)
          || Auth::user()->id == $request->id) {
            return $next($request);
        }
    }
}
