<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoIpService
{
    public function lookup(string $ip): array
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return ['city' => 'Local', 'country' => 'Local'];
        }

        return Cache::remember("geoip:{$ip}", 3600, function () use ($ip) {
            try {
                $data = Http::timeout(3)
                    ->get("http://ip-api.com/json/{$ip}", ['fields' => 'status,city,country'])
                    ->json();

                if (($data['status'] ?? '') === 'success') {
                    return ['city' => $data['city'], 'country' => $data['country']];
                }
            } catch (\Throwable) {
            }

            return ['city' => 'Unknown', 'country' => 'Unknown'];
        });
    }
}
