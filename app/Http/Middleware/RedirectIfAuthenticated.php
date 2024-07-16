<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard === 'admin' && Auth::guard('admin')->user()->hasRole('admin')) {
                return redirect()->route('admin.home');
            } elseif ($guard !== 'admin') {
                return redirect('/home'); 
            }
        }

        return $next($request);
    }
}
