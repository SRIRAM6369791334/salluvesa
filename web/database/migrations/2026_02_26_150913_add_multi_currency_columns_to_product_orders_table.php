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
            $table->string('base_currency', 3)->default('INR')->after('grand_total_amount');
            $table->decimal('base_amount', 15, 2)->nullable()->after('base_currency');
            $table->string('selected_currency', 3)->nullable()->after('base_amount');
            $table->decimal('converted_amount', 15, 2)->nullable()->after('selected_currency');
            $table->decimal('exchange_rate', 15, 6)->nullable()->after('converted_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->dropColumn([
                'base_currency',
                'base_amount',
                'selected_currency',
                'converted_amount',
                'exchange_rate'
            ]);
        });
    }
};
