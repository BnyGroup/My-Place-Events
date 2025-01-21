<?php

namespace App\Http\Middleware;

use Closure;

class CheckNewsletterAbonnes
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
        // Votre logique de middleware ici
        return $next($request);
    }
}