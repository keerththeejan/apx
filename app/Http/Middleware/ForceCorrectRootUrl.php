<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ForceCorrectRootUrl
{
    /**
     * Ensure route() and url() use the actual request domain (apx.lk),
     * not localhost from APP_URL. Fixes links on cPanel when .env has wrong APP_URL.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $root = $request->getSchemeAndHttpHost() . $request->getBasePath();
        if ($root) {
            URL::forceRootUrl(rtrim($root, '/'));
        }

        return $next($request);
    }
}
