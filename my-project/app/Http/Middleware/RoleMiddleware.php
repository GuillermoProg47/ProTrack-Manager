<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->session()->get('user');
        if (!$user) {
            return Redirect::route('login.form');
        }

        $userRole = $user['role'] ?? 'user';
        if ($userRole !== $role) {
            // Optionally redirect to home or 403
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
