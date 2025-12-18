<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        // Set the schema to https if using ngrok
        if (str_contains($request->host(), 'ngrok')) {
            URL::forceScheme('https');
        }

        // Trust proxy headers for ngrok
        if (str_contains($request->host(), 'ngrok')) {
            $request->setTrustedProxies(['*'], 
                Request::HEADER_X_FORWARDED_FOR | 
                Request::HEADER_X_FORWARDED_HOST | 
                Request::HEADER_X_FORWARDED_PROTO
            );
        }

        return $next($request);
    }
}
