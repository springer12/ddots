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
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (($request->id
                && (User::findOrFail($request->id)->hasRole(User::ROLE_TEACHER) //view profile page - id required
                    || (Auth::check()
                        && (Auth::user()->id == $request->id
                            || Auth::user()->isTeacherOf($request->id)))))
            || (!$request->id //view own edit/upgrade page - id not required
                && Auth::check())
        ) {
            return $next($request);
        } else {
            return abort(404);
        }
    }
}
