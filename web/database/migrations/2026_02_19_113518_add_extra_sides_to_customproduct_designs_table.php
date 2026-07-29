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
        Schema::table('customproduct_designs', function (Blueprint $table) {
            $table->json('design_json_right_shoulder')->nullable();
            $table->json('design_json_left_shoulder')->nullable();
            $table->string('preview_image_right_shoulder')->nullable();
            $table->string('preview_image_left_shoulder')->nullable();
            $table->string('status')->default('draft'); // draft, confirmed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customproduct_designs', function (Blueprint $table) {
            //
        });
    }
};
