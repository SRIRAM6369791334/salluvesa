<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                if (!Schema::hasColumn('carts', 'gsm')) {
                    $table->string('gsm', 255)->nullable();
                }
                if (!Schema::hasColumn('carts', 'cloth_type')) {
                    $table->string('cloth_type', 255)->nullable();
                }
            });
        }

        if (Schema::hasTable('product_slots')) {
            Schema::table('product_slots', function (Blueprint $table) {
                if (!Schema::hasColumn('product_slots', 'gsm')) {
                    $table->string('gsm', 255)->nullable();
                }
                if (!Schema::hasColumn('product_slots', 'cloth_type')) {
                    $table->string('cloth_type', 255)->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                if (Schema::hasColumn('carts', 'gsm')) {
                    $table->dropColumn('gsm');
                }
                if (Schema::hasColumn('carts', 'cloth_type')) {
                    $table->dropColumn('cloth_type');
                }
            });
        }

        if (Schema::hasTable('product_slots')) {
            Schema::table('product_slots', function (Blueprint $table) {
                if (Schema::hasColumn('product_slots', 'gsm')) {
                    $table->dropColumn('gsm');
                }
                if (Schema::hasColumn('product_slots', 'cloth_type')) {
                    $table->dropColumn('cloth_type');
                }
            });
        }
    }
};
