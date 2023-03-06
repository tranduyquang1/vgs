<?php

namespace App\Http\Middleware;

use Closure;

class PermissionSupport
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('userInfo')) {
            $userInfo = session('userInfo');
            if ($userInfo['support'] == 1) {
                return $next($request);
            }
            return redirect()->route('index/notfound');
        }
        return redirect()->route('auth/login');
    }
}