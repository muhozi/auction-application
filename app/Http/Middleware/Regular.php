<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Regular
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
        if ( Auth::check() && Auth::user()->isRegular() )
        {
            return $next($request);
        }
        return abort(404);
    }
}
