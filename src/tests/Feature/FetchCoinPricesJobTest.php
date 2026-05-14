<?php

namespace Tests\Feature;

use App\Prices\CoinGeckoService;
use App\Prices\CoinPrice;
use App\Prices\FetchCoinPricesJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchCoinPricesJobTest extends TestCase
{
    use RefreshDatabase;

    private array $prices = [
        'bitcoin' => 81236.0,
        'ethereum' => 2335.7,
        'tether' => 0.998879,
    ];

    public function test_saves_all_coins_to_database(): void
    {
        $this->mockService();

        (new FetchCoinPricesJob())->handle($this->app->make(CoinGeckoService::class));

        $this->assertDatabaseCount('coin_prices', 3);
        $this->assertDatabaseHas('coin_prices', ['coin_id' => 'bitcoin', 'price_usd' => 81236.0]);
        $this->assertDatabaseHas('coin_prices', ['coin_id' => 'ethereum', 'price_usd' => 2335.7]);
        $this->assertDatabaseHas('coin_prices', ['coin_id' => 'tether', 'price_usd' => 0.998879]);
    }

    public function test_all_records_share_the_same_fetched_at(): void
    {
        $this->mockService();

        (new FetchCoinPricesJob())->handle($this->app->make(CoinGeckoService::class));

        $uniqueFetchedAts = CoinPrice::pluck('fetched_at')->unique();
        $this->assertCount(1, $uniqueFetchedAts);
    }

    public function test_fetched_at_and_created_at_are_set(): void
    {
        $this->mockService();

        (new FetchCoinPricesJob())->handle($this->app->make(CoinGeckoService::class));

        $record = CoinPrice::first();
        $this->assertNotNull($record->fetched_at);
        $this->assertNotNull($record->created_at);
    }

    private function mockService(): void
    {
        $this->mock(CoinGeckoService::class)
            ->shouldReceive('fetchPrices')
            ->once()
            ->andReturn($this->prices);
    }
}
