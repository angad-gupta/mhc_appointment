<?php

namespace App\Http\Middleware;

use Closure;

class DoctorOnly
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
        if (auth()->user()->role == 2) {
            return $next($request);
        } else {
            return response()->view('errors.403', [], 403);
        }
    }
}
