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
            $table->string('print_position')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_layers', function (Blueprint $table) {
             // We can't easily revert to enum with strict mode, so assume string is fine or just leave it.
             // Or revert to text if needed.
             // $table->enum('print_position', ['front', 'back', 'chest', 'shoulder'])->change();
        });
    }
};
