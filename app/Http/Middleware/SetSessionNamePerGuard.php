<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class SetSessionNamePerGuard
{
    public function handle($request, Closure $next)
    {
        $path = $request->path();

        if (Str::startsWith($path, 'admin')) {
            config(['session.cookie' => 'laravel_admin_session']);
        } elseif (Str::startsWith($path, 'super')) {
            config(['session.cookie' => 'laravel_super_session']);
        } elseif (Str::startsWith($path, 'sales')) {
            config(['session.cookie' => 'laravel_sales_session']);
        } elseif (Str::startsWith($path, 'services')) {
            config(['session.cookie' => 'laravel_services_session']);
        } else {
            // Fallback for default login page
            config(['session.cookie' => 'laravel_web_session']);
        }

        return $next($request);
    }
}

