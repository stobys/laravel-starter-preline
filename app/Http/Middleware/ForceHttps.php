<?php

// app/Http/Middleware/ForceHttps.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        if (
            app()->environment(['production', 'staging'])
            && !$request->secure()
        ) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
