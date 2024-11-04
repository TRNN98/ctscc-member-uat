<?php

namespace App\Http\Middleware;

use Closure;

class AntihackMiddleware
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
        // $ip = $request->ip();
        // $arr_ip = geoip()->getLocation();

        // if ($arr_ip->iso_code !== "TH") {
        //     // header('HTTP/1.1 401 Authorization Required');
        //     // return response()->view('errors.' . '500', [], 500);
        //     abort('403', 'Country Not Allow.');
        //     // header('WWW-Authenticate: Basic realm="Access denied"');
        //     exit;
        // }

        // $AUTH_USER = 'admin';
        // $AUTH_PASS = 'admin';
        // header('Cache-Control: no-cache, must-revalidate, max-age=0');
        // $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        // $is_not_authenticated = (!$has_supplied_credentials ||
        //     $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
        //     $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS);
        // if ($is_not_authenticated) {
        //     header('HTTP/1.1 401 Authorization Required');
        //     header('WWW-Authenticate: Basic realm="Access denied"');
        //     exit;
        // }
        return $next($request);
    }
}
