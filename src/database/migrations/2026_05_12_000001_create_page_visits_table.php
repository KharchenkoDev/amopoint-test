<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45);
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('device', 20)->default('desktop');
            $table->text('user_agent')->nullable();
            $table->string('page_url', 2000)->nullable();
            $table->string('referrer', 2000)->nullable();
            $table->timestamp('visited_at');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
