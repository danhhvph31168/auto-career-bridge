<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    //  handle redirect after authentication
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                if ($user->user_type === 'enterprise' && $user->role_id === ROLE_ADMIN) {
                    return redirect(RouteServiceProvider::ENTERPRISE_DASHBOARD);
                } elseif ($user->user_type === 'university' && $user->role_id === ROLE_ADMIN) {
                    return redirect(RouteServiceProvider::UNIVERSITY_DASHBOARD);
                }
            }
        }

        return $next($request);
    }
}
