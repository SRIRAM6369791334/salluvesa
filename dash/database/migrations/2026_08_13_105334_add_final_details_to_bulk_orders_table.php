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
        Schema::table('bulk_orders', function (Blueprint $table) {
            $table->string('final_size')->nullable()->after('notes');
            $table->string('final_color')->nullable()->after('final_size');
            $table->integer('final_qty')->nullable()->after('final_color');
            $table->decimal('final_rate', 10, 2)->nullable()->after('final_qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bulk_orders', function (Blueprint $table) {
            $table->dropColumn(['final_size', 'final_color', 'final_qty', 'final_rate']);
        });
    }
};
