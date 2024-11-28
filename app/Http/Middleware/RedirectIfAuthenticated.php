<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // RedirectIfAuthenticated.php
        public function handle(Request $request, Closure $next, string ...$guards)
        {
            $guards = empty($guards) ? [null] : $guards;

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    // Redirection selon le rôle de l'utilisateur
                    $role = Auth::user()->role; // Assuming you have a 'role' field

                    if ($role === 'admin') {
                        return redirect()->route('admin.dashboard');
                    } elseif ($role === 'user') {
                        return redirect()->route('user.dashboard');
                    }
                }
            }

            return $next($request);
        }


}
