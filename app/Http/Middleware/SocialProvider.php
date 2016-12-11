<?php

namespace App\Http\Middleware;

use Closure;

class SocialProvider
{
    private $providers = ['google', 'facebook', 'vkontakte'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(in_array($request->provider, $this->providers)) {
            return $next($request);
        } else {
            abort(404);
        }
    }
}
