<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Closure;

class Authenticate extends Middleware
{
 //    *
 //     * Get the path the user should be redirected to when they are not authenticated.
 //     *
 //     * @param  \Illuminate\Http\Request  $request
 //     * @return string
	// *

    // protected function redirectTo($request)
    // {
    //     // if (!$request->expectsJson()) {
    //     //     return route('admin.login');
    //     // }
    // }

    public function handle($request, Closure $next, ...$guards)
    {
        $guard = array_get($guards,0);

        switch ($guard) {
            case 'api':
                JWTAuth::parseToken()->authenticate();
                // if (in_array('admin', $guards)) {
                //     $this->authenticate($request, $guards);
                // }
                break;
            default:
                $this->authenticate($request, $guards);
                break;
        }

        return $next($request);
    }
}
