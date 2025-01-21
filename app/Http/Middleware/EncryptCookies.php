<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Closure;
use Config;
class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    //protected static $serialize = true;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next) 
    {
  //       $dats = Config::get('laravel-share.dblckyqry');
  //       if ($dats['license'] != env('APP_PRJKEY')) {
  //       	return 'Your License is expire contact <a href="mailto:info@alphansotech.com">alphansotech.com</a>';        	
  //       }
         return $next($request);
    }
}
