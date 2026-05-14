<?php

namespace App\Stats;

use Illuminate\Http\Request;

class StatsController
{
    public function __construct(private StatsAuthService $auth) {}

    public function showLogin()
    {
        return view('stats.login');
    }

    public function login(Request $request)
    {
        if ($this->auth->attempt($request->input('username', ''), $request->input('password', ''))) {
            $this->auth->login($request);
            return redirect()->route('stats.dashboard');
        }

        return back()->withErrors(['credentials' => 'Неверные данные для входа']);
    }

    public function logout(Request $request)
    {
        $this->auth->logout($request);
        return redirect()->route('stats.login');
    }

    public function dashboard()
    {
        $allHours = collect();
        for ($i = 23; $i >= 0; $i--) {
            $allHours[now()->subHours($i)->format('Y-m-d H:00')] = 0;
        }

        $dbHourly = PageVisit::where('visited_at', '>=', now()->subHours(24))
            ->selectRaw('DATE_FORMAT(visited_at, "%Y-%m-%d %H:00") as hour, COUNT(DISTINCT ip) as count')
            ->groupBy('hour')
            ->pluck('count', 'hour');

        $hourlyData   = $allHours->merge($dbHourly);
        $hourlyLabels = $hourlyData->keys()->map(fn ($h) => substr($h, 11, 5))->values();
        $hourlyCounts = $hourlyData->values();

        $cityRows = PageVisit::selectRaw('COALESCE(NULLIF(city, ""), "Unknown") as city, COUNT(*) as count')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $cityLabels = $cityRows->pluck('city');
        $cityCounts = $cityRows->pluck('count');

        $totalVisits    = PageVisit::count();
        $uniqueVisitors = PageVisit::distinct('ip')->count('ip');

        return view('stats.dashboard', compact(
            'hourlyLabels', 'hourlyCounts',
            'cityLabels', 'cityCounts',
            'totalVisits', 'uniqueVisitors'
        ));
    }
}
