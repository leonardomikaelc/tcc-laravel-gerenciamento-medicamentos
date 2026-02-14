<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {

        if (!Auth::check() || (Auth::user()->role ?? 'user') !== 'admin') {
            return redirect()->route('home')->with('error', 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
