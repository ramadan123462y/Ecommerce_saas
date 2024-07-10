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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->integer('subtotal');
            $table->integer('quantity');
            $table->foreignId('cart_id')->references('id')->on('carts')->cascadeOnDelete();
            
            $table->foreignId('product_id')->nullable()->references('id')->on('products')->cascadeOnDelete();
            $table->string('product_name')->nullable();
            // $table->foreignId('')
            // id	cart_id	product_id


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
