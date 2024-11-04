<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Impersonate
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
        $req = $request->is('admin/impersonate/auth/member');
        if ($req) {
            if (session()->has('impersonate')) {
                Auth::guard('api')->login(session('impersonate'));
            }
        }

        return $next($request);
    }
}
