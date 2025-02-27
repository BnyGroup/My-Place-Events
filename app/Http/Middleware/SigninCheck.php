<?php

namespace App\Http\Middleware;

use Closure;

class SigninCheck
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
        if (auth()->guard('frontuser')->check()) {
            //dd(session('link_2'));
            //return redirect()->route('users.pro');
            if( is_null(session('link_2')) )
                return redirect(url('/'));
            return redirect(session('link_2'));
        }
        $response = $next($request);
        return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                 ->header('Pragma','no-cache')
                 ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
        
    }
}
