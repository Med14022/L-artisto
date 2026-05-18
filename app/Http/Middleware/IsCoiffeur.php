<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsCoiffeur
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'coiffeur') {
            return $next($request);
        }

        abort(403, 'Accès réservé aux coiffeurs.');
    }
}
