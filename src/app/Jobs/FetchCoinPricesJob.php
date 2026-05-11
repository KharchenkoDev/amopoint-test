<?php

namespace App\Jobs;

use App\Models\CoinPrice;
use App\Services\CoinGeckoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class FetchCoinPricesJob implements ShouldQueue
{
    use Queueable;

    public function handle(CoinGeckoService $service): void
    {
        $fetchedAt = now();
        $prices = $service->fetchPrices();

        foreach ($prices as $coinId => $priceUsd) {
            CoinPrice::create([
                'coin_id' => $coinId,
                'price_usd' => $priceUsd,
                'fetched_at' => $fetchedAt,
            ]);
        }

        Log::info('FetchCoinPricesJob: saved ' . count($prices) . ' coin prices', [
            'fetched_at' => $fetchedAt->toIso8601String(),
        ]);
    }
}
