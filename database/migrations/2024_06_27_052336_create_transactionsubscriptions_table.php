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
        Schema::create('transactionsubscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('stores');
            $table->foreignId('subscrubtion_id')->references('id')->on('subscrubtions');
            $table->string('payment_id');
            $table->enum('status_pay',['pay','unpay'])->default('unpay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactionsubscriptions');
    }
};
