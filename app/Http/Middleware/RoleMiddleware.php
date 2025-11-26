<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        if (!$user->isActive()) {
            auth()->logout();
            return redirect('/login')->withErrors([
                'email' => 'Your account is not active. Please contact an administrator.',
            ]);
        }

        if (!$user->hasRole($role)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
