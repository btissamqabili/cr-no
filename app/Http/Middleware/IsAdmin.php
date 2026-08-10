<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté ET que son rôle est "admin"
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // Il peut continuer
        }

        // Sinon on bloque l'accès
        abort(403, 'Accès réservé à l\'administrateur.');
    }
}