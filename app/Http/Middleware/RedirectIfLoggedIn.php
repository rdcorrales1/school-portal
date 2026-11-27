<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfLoggedIn
{
    /**
     * If a user is already logged in, send them to their role's home page
     * instead of showing the login page. They must log out first.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() !== null) {
            return redirect($request->user()->homeUrl());
        }

        return $next($request);
    }
}
