<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
USE Illuminate\support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session('logged_in')){
            Log::info ('User not logged in - redirecting');
            return redirect()->route('login')->with('error','Unauthorrized');   
        }
        return $next($request);
    }
}
