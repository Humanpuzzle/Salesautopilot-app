<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\SapiCredentials;

class EnsureSapiConfigured
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('settings/sapi') || $request->is('settings/login')) {
            return $next($request);
        }

        if (!SapiCredentials::isConfigured()) {
            return redirect('/settings/login');
        }

        return $next($request);
    }
}
