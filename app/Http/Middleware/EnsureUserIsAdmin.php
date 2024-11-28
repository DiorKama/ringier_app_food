<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);  // Si l'utilisateur est admin, continuer
        }

        return redirect('/dashboard');  // Sinon, rediriger vers /dashboard
    }
}

