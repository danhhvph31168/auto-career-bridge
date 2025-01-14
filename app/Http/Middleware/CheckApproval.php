<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // middleware handle check approved
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()->status === PENDING_APPROVE) {
            return redirect()->route('approve');
        }

        return $next($request);
    }
}
