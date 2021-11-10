<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $state)
    {
        if(!isLogin() && $state == "online") {
            return redirect('/');
        }
        else if(isLogin() && $state == "offline") {
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
