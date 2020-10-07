<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PatientOnly
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
        if(Auth::guard('extra_user')->check()){
            return $next($request);
        } else {
            return response()->view('errors.403', [], 403);
        }
    }
}
