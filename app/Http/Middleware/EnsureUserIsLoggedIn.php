<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{

    public function handle(Request $request, Closure $next)
    {
        //si pas de user dans la session -> pas connecté
        if(!$request->session()->has('user')) {
            return redirect('/login');
        }
        //sinon on laisse passer vers la route /controller
        return $next($request);
    }
}
