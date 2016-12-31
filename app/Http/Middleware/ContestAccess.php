<?php

namespace App\Http\Middleware;

use App\Contest;
use App\Solution;
use Closure;

class ContestAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) // @todo: check id in different requests
    {
        $contest_id = $request->id;
        if(!isset($contest_id)) {
            $contest_id = $request->contest_id;
        }
        if(!isset($contest_id) && isset($request->solution_id)) {
            $contest = Solution::findOrFail($request->solution_id)->getContest();
        } else {
            $contest = Contest::findOrFail($contest_id);
        }


        if($contest->labs || \Auth::id() == $contest->user_id) {
            return $next($request);
        }

        if($contest->users()->findOrFail(\Auth::id()) && $contest->is_active) {
            return $next($request);
        }

        abort(404);
    }
}
