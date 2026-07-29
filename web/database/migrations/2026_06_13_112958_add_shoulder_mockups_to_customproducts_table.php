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
        Schema::table('customproducts', function (Blueprint $table) {
            $table->string('right_shoulder_mockup')->nullable()->after('back_mockup');
            $table->string('left_shoulder_mockup')->nullable()->after('right_shoulder_mockup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customproducts', function (Blueprint $table) {
            $table->dropColumn(['right_shoulder_mockup', 'left_shoulder_mockup']);
        });
    }
};
