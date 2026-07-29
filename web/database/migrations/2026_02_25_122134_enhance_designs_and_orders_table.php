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
            if (!Schema::hasColumn('customproduct_designs', 'design_name')) {
                $table->string('design_name')->nullable()->after('customproduct_id');
            }
            if (!Schema::hasColumn('customproduct_designs', 'thumbnail_path')) {
                $table->string('thumbnail_path')->nullable()->after('preview_image_left_shoulder');
            }
        });

        Schema::table('product_slots', function (Blueprint $table) {
            if (!Schema::hasColumn('product_slots', 'design_id')) {
                $table->unsignedBigInteger('design_id')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('product_slots', 'snapshot_path')) {
                $table->string('snapshot_path')->nullable()->after('design_id');
            }
            if (!Schema::hasColumn('product_slots', 'snapshot_json')) {
                $table->longText('snapshot_json')->nullable()->after('snapshot_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customproduct_designs', function (Blueprint $table) {
            $table->dropColumn(['design_name', 'thumbnail_path']);
        });

        Schema::table('product_slots', function (Blueprint $table) {
            $table->dropColumn(['design_id', 'snapshot_path', 'snapshot_json']);
        });
    }
};
