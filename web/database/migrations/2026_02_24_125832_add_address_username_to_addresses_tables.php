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
        if (Schema::hasTable('user_addresses')) {
            Schema::table('user_addresses', function (Blueprint $table) {
                if (!Schema::hasColumn('user_addresses', 'address_username')) {
                    $table->string('address_username')->nullable()->after('id');
                }
            });
        }

        if (Schema::hasTable('product_order_user_addresses')) {
            Schema::table('product_order_user_addresses', function (Blueprint $table) {
                if (!Schema::hasColumn('product_order_user_addresses', 'address_username')) {
                    $table->string('address_username')->nullable()->after('id');
                }
                if (!Schema::hasColumn('product_order_user_addresses', 'country')) {
                    $table->string('country')->nullable()->after('pincode');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('user_addresses')) {
            Schema::table('user_addresses', function (Blueprint $table) {
                $table->dropColumn('address_username');
            });
        }

        if (Schema::hasTable('product_order_user_addresses')) {
            Schema::table('product_order_user_addresses', function (Blueprint $table) {
                $table->dropColumn(['address_username', 'country']);
            });
        }
    }
};
