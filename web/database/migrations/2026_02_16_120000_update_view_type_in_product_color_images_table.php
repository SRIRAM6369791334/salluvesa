<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // specific to MySQL
        DB::statement("ALTER TABLE product_color_images MODIFY COLUMN view_type ENUM('front', 'back', 'chest', 'shoulder', 'right-shoulder', 'left-shoulder') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE product_color_images MODIFY COLUMN view_type ENUM('front', 'back', 'chest', 'shoulder') NOT NULL");
    }
};
