<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\App;

class Tournament
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
        if ($request->session()->has('locale')) {
            App::setLocale(session('locale'));
       }

        return $next($request);
    }
}