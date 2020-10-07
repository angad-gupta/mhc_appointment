<?php

namespace App\Http\Middleware\Installer;

use Closure;

class IsInstalled
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
        if (config('installer.steps.finish') == 0) {
            return redirect()->to('/install');
        } else {
            return $next($request);
        }

    }
}
