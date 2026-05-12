<?php

namespace App\Http\Middleware;

use App\Services\StatsAuthService;
use Closure;
use Illuminate\Http\Request;

class EnsureStatsAuthenticated
{
    public function __construct(private StatsAuthService $auth) {}

    public function handle(Request $request, Closure $next)
    {
        if (!$this->auth->check($request)) {
            return redirect()->route('stats.login');
        }

        return $next($request);
    }
}
