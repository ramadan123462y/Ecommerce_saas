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
        Schema::create('payment_store', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paymentmethod_id')->references('id')->on('payment_methods')->cascadeOnDelete();
            $table->foreignId('store_id')->references('id')->on('stores')->cascadeOnDelete();
            $table->string('api_key',1000)->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_store');
    }
};
