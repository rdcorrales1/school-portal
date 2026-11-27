<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackCache
{
    /**
     * Tell the browser not to keep a copy of each page.
     *
     * Without this, the browser's Back button can show a saved copy of the
     * login page without asking the server. With no copy kept, Back asks the
     * server again, and RedirectIfLoggedIn sends a logged-in user to their
     * dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');

        return $response;
    }
}
