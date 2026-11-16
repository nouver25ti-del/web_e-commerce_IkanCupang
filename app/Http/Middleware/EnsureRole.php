<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Pakai: ->middleware('role:admin') atau ->middleware('role:customer').
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! in_array($user->role, $roles, true)) {
            return redirect($user->homeUrl())
                ->with('status', 'Anda tidak punya akses ke halaman itu.');
        }

        return $next($request);
    }
}
