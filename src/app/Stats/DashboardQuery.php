<?php

namespace App\Stats;

use Illuminate\Support\Collection;

class DashboardQuery
{
    public function hourlyLabels(): Collection
    {
        return $this->hourlyData()->keys()->map(fn ($h) => substr($h, 11, 5))->values();
    }

    public function hourlyCounts(): Collection
    {
        return $this->hourlyData()->values();
    }

    public function topCityLabels(int $limit = 10): Collection
    {
        return $this->topCities($limit)->map(fn ($r) => $r->city ?: 'Unknown');
    }

    public function topCityCounts(int $limit = 10): Collection
    {
        return $this->topCities($limit)->pluck('count');
    }

    public function totalVisits(): int
    {
        return PageVisit::count();
    }

    public function uniqueVisitors(): int
    {
        return PageVisit::distinct('ip')->count('ip');
    }

    private function hourlyData(): Collection
    {
        $slots = collect();
        for ($i = 23; $i >= 0; $i--) {
            $slots[now()->subHours($i)->format('Y-m-d H:00')] = 0;
        }

        $dbCounts = PageVisit::where('visited_at', '>=', now()->subHours(24))
            ->select('ip', 'visited_at')
            ->get()
            ->groupBy(fn ($v) => $v->visited_at->format('Y-m-d H:00'))
            ->map(fn ($group) => $group->pluck('ip')->unique()->count());

        return $slots->merge($dbCounts);
    }

    public function recentVisits(int $limit = 50): Collection
    {
        return PageVisit::select('ip', 'city', 'country', 'device', 'page_url', 'visited_at')
            ->orderByDesc('visited_at')
            ->limit($limit)
            ->get();
    }

    private function topCities(int $limit): Collection
    {
        return PageVisit::select('city', \Illuminate\Support\Facades\DB::raw('COUNT(*) as count'))
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }
}
