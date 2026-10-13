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
        if (Schema::hasTable('customproducts')) {
            Schema::table('customproducts', function (Blueprint $table) {
                if (!Schema::hasColumn('customproducts', 'sizes')) {
                    $table->longText('sizes')->nullable();
                }
                if (!Schema::hasColumn('customproducts', 'cloth_types')) {
                    $table->string('cloth_types', 255)->nullable();
                }
                if (!Schema::hasColumn('customproducts', 'gsm')) {
                    $table->longText('gsm')->nullable();
                }
                if (!Schema::hasColumn('customproducts', 'colors')) {
                    $table->longText('colors')->nullable();
                }
                if (!Schema::hasColumn('customproducts', 'features')) {
                    $table->longText('features')->nullable();
                }
                if (!Schema::hasColumn('customproducts', 'badge')) {
                    $table->string('badge', 255)->nullable();
                }
                if (!Schema::hasColumn('customproducts', 'badge_type')) {
                    $table->string('badge_type', 255)->nullable();
                }
                if (!Schema::hasColumn('customproducts', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (!Schema::hasColumn('customproducts', 'is_active')) {
                    $table->tinyInteger('is_active')->default(1);
                }
            });
        }

        if (Schema::hasTable('designs')) {
            Schema::table('designs', function (Blueprint $table) {
                if (!Schema::hasColumn('designs', 'gsm')) {
                    $table->longText('gsm')->nullable();
                }
                if (!Schema::hasColumn('designs', 'colors')) {
                    $table->longText('colors')->nullable();
                }
                if (!Schema::hasColumn('designs', 'features')) {
                    $table->longText('features')->nullable();
                }
                if (!Schema::hasColumn('designs', 'badge')) {
                    $table->string('badge', 255)->nullable();
                }
                if (!Schema::hasColumn('designs', 'badge_type')) {
                    $table->string('badge_type', 255)->nullable();
                }
                if (!Schema::hasColumn('designs', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (!Schema::hasColumn('designs', 'is_active')) {
                    $table->tinyInteger('is_active')->default(1);
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
        if (Schema::hasTable('customproducts')) {
            Schema::table('customproducts', function (Blueprint $table) {
                $cols = ['sizes', 'cloth_types', 'gsm', 'colors', 'features', 'badge', 'badge_type', 'sort_order', 'is_active'];
                foreach ($cols as $col) {
                    if (Schema::hasColumn('customproducts', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('designs')) {
            Schema::table('designs', function (Blueprint $table) {
                $cols = ['gsm', 'colors', 'features', 'badge', 'badge_type', 'sort_order', 'is_active'];
                foreach ($cols as $col) {
                    if (Schema::hasColumn('designs', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
