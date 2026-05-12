<?php

namespace Tests\Feature;

use App\Models\CoinPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricesApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_paginated_prices(): void
    {
        CoinPrice::create(['coin_id' => 'bitcoin', 'price_usd' => 81236.0, 'fetched_at' => now()]);
        CoinPrice::create(['coin_id' => 'ethereum', 'price_usd' => 2335.7, 'fetched_at' => now()]);

        $this->getJson('/api/prices')
            ->assertOk()
            ->assertJsonPath('total', 2)
            ->assertJsonCount(2, 'data');
    }

    public function test_returns_empty_data_when_no_records(): void
    {
        $this->getJson('/api/prices')
            ->assertOk()
            ->assertJsonPath('total', 0)
            ->assertJsonCount(0, 'data');
    }

    public function test_filters_by_coin_id(): void
    {
        CoinPrice::create(['coin_id' => 'bitcoin', 'price_usd' => 81236.0, 'fetched_at' => now()]);
        CoinPrice::create(['coin_id' => 'ethereum', 'price_usd' => 2335.7, 'fetched_at' => now()]);

        $this->getJson('/api/prices?coin_id=bitcoin')
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.coin_id', 'bitcoin');
    }

    public function test_paginates_with_per_page(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            CoinPrice::create(['coin_id' => 'bitcoin', 'price_usd' => $i * 1000, 'fetched_at' => now()]);
        }

        $this->getJson('/api/prices?per_page=2')
            ->assertOk()
            ->assertJsonPath('total', 5)
            ->assertJsonPath('per_page', 2)
            ->assertJsonCount(2, 'data');
    }

    public function test_per_page_is_capped_at_500(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            CoinPrice::create(['coin_id' => 'bitcoin', 'price_usd' => $i * 1000, 'fetched_at' => now()]);
        }

        $this->getJson('/api/prices?per_page=999')
            ->assertOk()
            ->assertJsonPath('per_page', 500);
    }

    public function test_pagination_and_coin_id_filter_work_together(): void
    {
        CoinPrice::create(['coin_id' => 'bitcoin', 'price_usd' => 81000.0, 'fetched_at' => now()]);
        CoinPrice::create(['coin_id' => 'bitcoin', 'price_usd' => 82000.0, 'fetched_at' => now()]);
        CoinPrice::create(['coin_id' => 'ethereum', 'price_usd' => 2335.0, 'fetched_at' => now()]);

        $this->getJson('/api/prices?coin_id=bitcoin&per_page=1')
            ->assertOk()
            ->assertJsonPath('total', 2)
            ->assertJsonCount(1, 'data');
    }
}
