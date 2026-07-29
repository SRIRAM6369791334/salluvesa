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
        if (!Schema::hasTable('customproduct_designs')) {
            Schema::create('customproduct_designs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('customproduct_id')->constrained('customproducts')->onDelete('cascade');
                $table->integer('canvas_width');
                $table->integer('canvas_height');
                $table->string('product_color');
                $table->string('product_size');
                $table->json('front_canvas_json')->nullable();
                $table->json('back_canvas_json')->nullable();
                $table->string('preview_image_front')->nullable();
                $table->string('preview_image_back')->nullable();
                $table->timestamps();

                // Indexes for performance
                $table->index('user_id');
                $table->index('customproduct_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customproduct_designs');
    }
};
