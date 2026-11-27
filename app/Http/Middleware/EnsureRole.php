<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Allow the request only if the logged-in user has one of the given roles.
     *
     * Use it on a route like this: ->middleware(['auth', 'role:teacher'])
     * Several roles are allowed too:  role:teacher,principal
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Wrong role (or no user at all) gets 403 Forbidden.
        if (! $user || ! in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
