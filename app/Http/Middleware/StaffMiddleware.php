<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Check if the user is authenticated and has the 'staff' role_as
         if (Auth::check() && Auth::user()->role_as == 2) {
            return $next($request);
        }

        // Redirect or respond with an error if the user is not staff
        return redirect('/home')->with('status', 'Access Denied! Staff Authorization Required.');
    }
}
