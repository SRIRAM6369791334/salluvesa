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
        Schema::table('product_orders', function (Blueprint $table) {
            $table->integer('gst_amount')->default(0)->change();
            $table->integer('discount_amount')->default(0)->change();
            $table->integer('delivery_charge')->default(0)->change();
            $table->integer('is_cancelled')->default(0)->change();
            $table->integer('approve_staus')->default(0)->change();
            $table->integer('grand_total_amount')->default(0)->change();
        });

        Schema::table('product_slots', function (Blueprint $table) {
            $table->integer('approve_staus')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_orders', function (Blueprint $table) {
            // Reverting defaults to NULL might not be possible/stable depending on DB, 
            // but we can try to change back to what it was.
            // For now, we'll just leave it as is or try to remove default.
        });
    }
};
