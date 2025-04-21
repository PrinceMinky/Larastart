<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class FollowRequestMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $followRequestCount = Auth::user()->followers()->wherePivot('status', 'pending')->count();
            View::share('followRequestCount', $followRequestCount);
        }

        return $next($request);
    }
}
