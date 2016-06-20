<?php

namespace App\Http\Middleware;

use Closure;

class Access extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $except = false, $roles = [])
    {
        $roles = is_array($roles) ? $roles : array_slice(func_get_args(), 4);

        return parent::handle($request, function ($request) use ($next, $guard, $except, $roles) {
            if($except && \Auth::guard($guard)->user()->can('access-role-routes', $roles)) {
                return $this->handleUnauthorizedRequest($request);
            } else if(!$except && \Auth::guard($guard)->user()->cant('access-role-routes', $roles)) {
                return $this->handleUnauthorizedRequest($request);
            }
            return $next($request);
        }, $guard);

    }
}
