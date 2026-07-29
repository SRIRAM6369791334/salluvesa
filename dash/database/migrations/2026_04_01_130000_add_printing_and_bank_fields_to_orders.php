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
            $table->string('printing_method')->nullable()->after('order_type');
            $table->string('bank_country')->nullable()->after('payment_method');
        });

        Schema::table('sample_order_full_details', function (Blueprint $table) {
            $table->string('printing_method')->nullable()->after('order_id');
            $table->string('bank_country')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->dropColumn(['printing_method', 'bank_country']);
        });

        Schema::table('sample_order_full_details', function (Blueprint $table) {
            $table->dropColumn(['printing_method', 'bank_country']);
        });
    }
};
