<?php

namespace App\Http\Middleware;

use App\Contest;
use Closure;

class ContestStandingsAccess
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
        $contest = Contest::findOrFail($request->id);
        if ($contest->is_standings_active || \Auth::id() == $contest->user_id) {
            return $next($request);
        }
        abort(404);
    }
}
