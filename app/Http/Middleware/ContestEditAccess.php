<?php

namespace App\Http\Middleware;

use App\Contest;
use Closure;

class ContestEditAccess
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
        if (Contest::findOrFail($request->id)->currentUserAllowedEdit()) {
            return $next($request);
        }
        abort(404);
    }
}
