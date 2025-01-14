<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$user_types): Response
    {
        $user = Auth::user();

        if (!$user) {
            return abort(401, 'Unauthorized');
        }

        if ($user->role_id === ROLE_ADMIN && in_array($user->user_type, $user_types)) {
            return $next($request);
        }
        return abort(404);
    }
}
