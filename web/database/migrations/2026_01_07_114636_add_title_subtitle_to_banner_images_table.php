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
        Schema::table('banner_images', function (Blueprint $table) {
            if (!Schema::hasColumn('banner_images', 'title')) {
                $table->string('title')->nullable();
            }
            if (!Schema::hasColumn('banner_images', 'subtitle')) {
                $table->string('subtitle')->nullable();
            }
            if (!Schema::hasColumn('banner_images', 'button_text')) {
                $table->string('button_text')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_images', function (Blueprint $table) {
            $table->dropColumn(['title', 'subtitle', 'button_text']);
        });
    }
};
