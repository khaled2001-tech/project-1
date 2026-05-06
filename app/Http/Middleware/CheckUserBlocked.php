<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

class CheckUserBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  public function handle(Request $request, Closure $next)
{
    if (auth()->check() && auth()->user()->status === 'blocked') {
        auth()->logout();
        return redirect()->route('login')
               ->with('error', 'Your account has been blocked. Please contact support.');
    }

    return $next($request);
}
}
