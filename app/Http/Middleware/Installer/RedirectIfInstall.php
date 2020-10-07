<?php

namespace App\Http\Middleware\Installer;

use Closure;

class RedirectIfInstall
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

        if (config('installer.steps.finish') == 1) {
            return redirect()->to('/');
        } else {
            return $next($request);
        }

    }
}
