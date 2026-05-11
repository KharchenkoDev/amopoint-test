<?php

namespace Tests\Feature;

use App\Jobs\FetchCoinPricesJob;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class FetchPricesCommandTest extends TestCase
{
    public function test_dispatches_job_and_exits_successfully(): void
    {
        Queue::fake();

        $this->artisan('app:fetch-prices')
            ->expectsOutput('FetchCoinPricesJob dispatched.')
            ->assertExitCode(0);

        Queue::assertPushed(FetchCoinPricesJob::class);
    }
}
