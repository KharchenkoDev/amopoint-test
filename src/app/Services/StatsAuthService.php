<?php

namespace App\Services;

use Illuminate\Http\Request;

class StatsAuthService
{
    public function attempt(string $login, string $password): bool
    {
        return $login === config('stats.login')
            && $password === config('stats.password');
    }

    public function login(Request $request): void
    {
        $request->session()->put('stats_authenticated', true);
    }

    public function logout(Request $request): void
    {
        $request->session()->forget('stats_authenticated');
    }

    public function check(Request $request): bool
    {
        return (bool) $request->session()->get('stats_authenticated');
    }
}
