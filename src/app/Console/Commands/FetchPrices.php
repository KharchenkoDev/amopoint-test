<?php

namespace App\Console\Commands;

use App\Jobs\FetchCoinPricesJob;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:fetch-prices')]
#[Description('Dispatch a job to fetch BTC, ETH, USDT prices from CoinGecko')]
class FetchPrices extends Command
{
    public function handle(): int
    {
        FetchCoinPricesJob::dispatch();
        $this->info('FetchCoinPricesJob dispatched.');

        return Command::SUCCESS;
    }
}
