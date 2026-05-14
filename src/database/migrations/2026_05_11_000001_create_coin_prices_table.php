<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('coin_prices', function (Blueprint $table) {
            $table->id();
            $table->string('coin_id', 50);
            $table->decimal('price_usd', 20, 8);
            $table->timestamp('fetched_at');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['coin_id', 'fetched_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coin_prices');
    }
};
