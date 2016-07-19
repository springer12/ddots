<?php

namespace App\Http\Middleware;

use App\Solution;
use App\User;
use Closure;

class ContestSolutionAccess
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
        if(Auth::user()->hasRole(User::ROLE_TEACHER) || Solution::findOrFail($request->id)->owner->id == Auth::user()->id) {
            return $next($request);
        }
        abort(404);
    }
}
