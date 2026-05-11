<?php

namespace Tests\Unit;

use App\Services\CoinGeckoService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CoinGeckoServiceTest extends TestCase
{
    public function test_returns_prices_indexed_by_coin_id(): void
    {
        Http::fake([
            '*' => Http::response([
                'bitcoin' => ['usd' => 81236.0],
                'ethereum' => ['usd' => 2335.7],
                'alloy-tether' => ['usd' => 0.998879],
            ]),
        ]);

        $prices = (new CoinGeckoService())->fetchPrices();

        $this->assertEquals([
            'bitcoin' => 81236.0,
            'ethereum' => 2335.7,
            'alloy-tether' => 0.998879,
        ], $prices);
    }

    public function test_throws_on_http_error(): void
    {
        Http::fake(['*' => Http::response([], 500)]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('CoinGecko API returned HTTP 500');

        (new CoinGeckoService())->fetchPrices();
    }

    public function test_throws_on_empty_response(): void
    {
        Http::fake(['*' => Http::response([])]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('CoinGecko API returned an unexpected response');

        (new CoinGeckoService())->fetchPrices();
    }
}
