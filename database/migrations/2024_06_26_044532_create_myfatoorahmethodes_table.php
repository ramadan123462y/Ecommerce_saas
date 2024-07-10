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
        Schema::create('myfatoorahmethodes', function (Blueprint $table) {
            $table->id();
            $table->integer('PaymentMethodId');
            $table->string('PaymentMethodAr');
            $table->string('PaymentMethodEn');
            $table->string('ImageUrl');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('myfatoorahmethodes');
    }
};
