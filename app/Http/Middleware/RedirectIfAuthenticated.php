<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = 'frontuser')
    {
        // $userdata = ['id' => str_shuffle(time()), 'UserName' => "Guest User", 'GuestEmail' => ''];
        // if (! Auth::guard($guard)->check()) {
        //     if(\Session::has('guestUser')):
        //        //
        //     else:
        //         \Session::put('guestUser', $userdata);
        //     endif;            
        // }        
        $response = $next($request);

        return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                 ->header('Pragma','no-cache')
                 ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
        // if (Auth::check()) {
        //     return redirect()->route('admin.index');
        // }
        //return $next($request);
        // return $next($request);
    }
}
