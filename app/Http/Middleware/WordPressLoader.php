<?php

namespace App\Http\Middleware;

use Closure;

class WordPressLoader
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
        $actions = $request->route()->getAction();

        // Make sure out custom name attribute is set and equals frontend
        if(isset($actions['name']) && $actions['name'] == 'frontend') {
            // Register our service provider
            app()->register(\App\Providers\WordpressServiceProvider::class);
        }

        return $next($request);
    }
}