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
        Schema::table('design_layers', function (Blueprint $table) {
            $table->string('layer_name')->nullable()->after('layer_type');
            $table->string('source_path', 500)->nullable()->after('layer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_layers', function (Blueprint $table) {
            $table->dropColumn(['layer_name', 'source_path']);
        });
    }
};
