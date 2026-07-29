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
        Schema::create('sample_order_full_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_primary_id'); // FK to product_orders.id
            $table->string('order_id')->nullable(); // External order ID string

            // User Snapshot
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();

            // Address Snapshot
            $table->string('address_username')->nullable();
            $table->string('address_phone_number')->nullable();
            $table->string('address_line_one')->nullable();
            $table->string('address_line_two')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('country')->nullable();
            $table->string('address_type_name')->nullable();

            // Order & Payment Summary
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('grand_total_amount', 10, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('payment_status_text')->nullable();

            // Product/Sample Data (Stored as JSON for flexibility, or you can use a separate table if preferred, but snapshotting as JSON is common for "Full Details" requirements)
            $table->json('order_items')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_order_full_details');
    }
};
