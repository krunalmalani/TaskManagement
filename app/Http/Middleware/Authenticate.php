<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }
        
        // Check if the request is for admin routes
        if (strpos($request->path(), 'admin/') === 0) {
            return route('admin.login');
        }
        
        // Default to admin.login if that's your main login
        return route('sadmin.login');
    }
}