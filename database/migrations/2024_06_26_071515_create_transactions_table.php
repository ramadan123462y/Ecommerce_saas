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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('stores')->cascadeOnDelete();
            $table->foreignId('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->string('id_payment')->nullable();
            $table->enum('status', ['pending', 'complete', 'failed'])->default('pending');
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
