<?php

namespace App\Stats;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackController
{
    public function store(Request $request, GeoIpService $geoIp): JsonResponse
    {
        $ip = $request->ip();
        $geo = $geoIp->lookup($ip);
        $userAgent = $request->userAgent() ?? '';

        PageVisit::create([
            'ip'         => $ip,
            'city'       => $geo['city'],
            'country'    => $geo['country'],
            'device'     => $this->detectDevice($userAgent),
            'user_agent' => $userAgent,
            'page_url'   => $request->input('url'),
            'referrer'   => $request->input('referrer'),
            'visited_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }

    private function detectDevice(string $ua): string
    {
        if (preg_match('/tablet|ipad|playbook|silk/i', $ua)) {
            return 'tablet';
        }

        if (preg_match('/mobile|android|iphone|ipod|blackberry|opera mini|windows phone/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }
}
