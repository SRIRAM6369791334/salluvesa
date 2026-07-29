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
        Schema::create('exchange_rates', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->string('base_currency', 3)->index();
            $table->string('target_currency', 3)->index();
            $table->decimal('rate', 15, 6);
            $table->timestamps();
            
            $table->unique(['base_currency', 'target_currency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
