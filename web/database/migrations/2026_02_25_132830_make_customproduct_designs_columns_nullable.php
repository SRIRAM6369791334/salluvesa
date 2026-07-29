<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customproduct_designs', function (Blueprint $table) {
            // Make previously NOT NULL columns nullable with defaults
            $table->integer('canvas_width')->nullable()->default(400)->change();
            $table->integer('canvas_height')->nullable()->default(500)->change();
            $table->string('product_color')->nullable()->default('white')->change();
            $table->string('product_size')->nullable()->default('M')->change();
        });
    }

    public function down(): void
    {
        Schema::table('customproduct_designs', function (Blueprint $table) {
            $table->integer('canvas_width')->nullable(false)->default(null)->change();
            $table->integer('canvas_height')->nullable(false)->default(null)->change();
            $table->string('product_color')->nullable(false)->default(null)->change();
            $table->string('product_size')->nullable(false)->default(null)->change();
        });
    }
};
