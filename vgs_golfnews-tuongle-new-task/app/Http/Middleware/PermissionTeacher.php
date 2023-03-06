<?php

namespace App\Http\Middleware;

use Closure;

class PermissionTeacher
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
            if ($userInfo['teacher'] == 1) {
                return $next($request);
            }
            return redirect()->route('index/notfound');
        }
        return redirect()->route('auth/login');
    }
}