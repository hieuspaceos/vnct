<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Auth_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            if(Auth::user()->Level>0)
            {
                return $next($request);
            }
            else
            {
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('login_admin');
        }
    }
}
