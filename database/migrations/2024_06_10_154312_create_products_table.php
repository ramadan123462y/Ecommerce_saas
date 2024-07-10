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
        Schema::create('products', function (Blueprint $table) {
            $table->id();


            $table->string('name', 20);
            $table->string('slug')->nullable();
            $table->integer('original_price');
            $table->integer('selling_price');
            $table->text('description')->nullable();
            $table->text('small_description')->nullable();
            $table->integer('quantity');
            $table->boolean('trending')->default(0);
            $table->boolean('status')->default(0);

            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_descreption')->nullable();

            $table->foreignId('store_id')->references('id')->on('stores')->cascadeOnDelete();
            $table->foreignId('categorie_id')->references('id')->on('categories')->cascadeOnDelete();






            // store_id

            // categorie_id
            // brand_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
