<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->session()->get('user');

        if (!$user || $user['roleUtilisateur'] !== $role) {
            abort(403, 'Accès refusé!');
        }
        return $next($request);
    }
}
