<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('coin_prices', function (Blueprint $table) {
            $table->index(['coin_id', 'fetched_at']);
        });
    }

    public function down(): void
    {
        Schema::table('coin_prices', function (Blueprint $table) {
            $table->dropIndex(['coin_id', 'fetched_at']);
        });
    }
};
