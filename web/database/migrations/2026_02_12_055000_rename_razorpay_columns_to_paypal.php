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
        // Rename columns in product_orders table
        if (Schema::hasTable('product_orders')) {
            Schema::table('product_orders', function (Blueprint $table) {
                if (Schema::hasColumn('product_orders', 'razorpay_order_id')) {
                    $table->renameColumn('razorpay_order_id', 'paypal_payment_id');
                }
                if (Schema::hasColumn('product_orders', 'razorpay_payment_id')) {
                    $table->renameColumn('razorpay_payment_id', 'paypal_payer_id');
                }
            });
        }

        // Rename columns in sample_order_full_details table
        if (Schema::hasTable('sample_order_full_details')) {
            Schema::table('sample_order_full_details', function (Blueprint $table) {
                if (Schema::hasColumn('sample_order_full_details', 'razorpay_order_id')) {
                    $table->renameColumn('razorpay_order_id', 'paypal_payment_id');
                }
                if (Schema::hasColumn('sample_order_full_details', 'razorpay_payment_id')) {
                    $table->renameColumn('razorpay_payment_id', 'paypal_payer_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse column renames in product_orders table
        if (Schema::hasTable('product_orders')) {
            Schema::table('product_orders', function (Blueprint $table) {
                if (Schema::hasColumn('product_orders', 'paypal_payment_id')) {
                    $table->renameColumn('paypal_payment_id', 'razorpay_order_id');
                }
                if (Schema::hasColumn('product_orders', 'paypal_payer_id')) {
                    $table->renameColumn('paypal_payer_id', 'razorpay_payment_id');
                }
            });
        }

        // Reverse column renames in sample_order_full_details table
        if (Schema::hasTable('sample_order_full_details')) {
            Schema::table('sample_order_full_details', function (Blueprint $table) {
                if (Schema::hasColumn('sample_order_full_details', 'paypal_payment_id')) {
                    $table->renameColumn('paypal_payment_id', 'razorpay_order_id');
                }
                if (Schema::hasColumn('sample_order_full_details', 'paypal_payer_id')) {
                    $table->renameColumn('paypal_payer_id', 'razorpay_payment_id');
                }
            });
        }
    }
};
