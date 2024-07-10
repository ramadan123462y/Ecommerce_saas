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
        Schema::create('subscrubtions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('starts_at')->default(Carbon\Carbon::now());
            $table->timestamp('ends_at')->default(Carbon\Carbon::now()->addMonth());
            $table->foreignId('plan_id')->references('id')->on('plans');
            
            $table->enum('status_pay',['pay','unpay'])->default('unpay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscrubtions');
    }
};
