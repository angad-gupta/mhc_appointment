<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfPatient
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('extra_user')->check()){
            return response()->view('errors.403', [], 403);
        } else {
            return $next($request);
        }
    }
}
