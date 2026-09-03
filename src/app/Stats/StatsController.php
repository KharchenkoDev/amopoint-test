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

    public function dashboard(DashboardQuery $query)
    {
        return view('stats.dashboard', [
            'hourlyLabels'   => $query->hourlyLabels(),
            'hourlyCounts'   => $query->hourlyCounts(),
            'cityLabels'     => $query->topCityLabels(),
            'cityCounts'     => $query->topCityCounts(),
            'totalVisits'    => $query->totalVisits(),
            'uniqueVisitors' => $query->uniqueVisitors(),
            'recentVisits'   => $query->recentVisits(),
        ]);
    }
}
