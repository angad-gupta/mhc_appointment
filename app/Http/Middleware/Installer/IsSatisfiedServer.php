<?php

namespace App\Http\Middleware\Installer;

use Closure;

class IsSatisfiedServer
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
        $server_requirement_satisfy = true;
        foreach (config('installer.requirements') as $requirement) {
            if (!extension_loaded($requirement)) {
                return redirect()->to('/install');
            }
        }
        return $next($request);
    }
}
