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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_domain')->unique();
            $table->string('logo', 1000)->nullable();
            $table->boolean('active')->default(0);
            $table->foreignId('plan_id')->nullable()->references('id')->on('plans');
            $table->foreignId('subscrubtion_id')->nullable()->references('id')->on('subscrubtions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
