<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('idempotency_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->cascadeOnDelete();
            $table->string('key',128);
            $table->string('request_path');
            $table->string('request_payload_hash',64);
            $table->smallInteger('response_code')->nullable();
            $table->json('response_body')->nullable();
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();

            $table->unique(['merchant_id', 'key']);
            $table->index('locked_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idempotency_keys');
    }
};
