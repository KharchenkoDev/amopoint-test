<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinGeckoService
{
    public function fetchPrices(): array
    {
        $config = config('services.coingecko');
        $coins  = implode(',', $config['coins']);

        $response = Http::timeout(10)->get($config['base_url'] . '/simple/price', [
            'ids'              => $coins,
            'vs_currencies'    => 'usd',
            'x_cg_demo_api_key' => $config['api_key'],
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException('CoinGecko API returned HTTP ' . $response->status());
        }

        $data = $response->json();

        if (! is_array($data) || empty($data)) {
            throw new \RuntimeException('CoinGecko API returned an unexpected response');
        }

        return array_map(fn($coin) => $coin['usd'], $data);
    }
}
