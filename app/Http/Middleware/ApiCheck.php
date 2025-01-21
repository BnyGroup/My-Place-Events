<?php

namespace App\Http\Middleware;

use Closure;

class ApiCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'api')
    {

        // if (!\Auth::guard('api')->check()) {
        //     $post['data']       = array();
        //     $post['message']    = 'You are not login!';
        //     $post['response']   = false;        
        //     return response()->json($post);
        // }
        return $response = $next($request);

        // return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
        //          ->header('Pragma','no-cache')
        //          ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
    }
}
