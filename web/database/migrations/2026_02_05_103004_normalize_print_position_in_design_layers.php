<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // We use a raw statement to change the enum
        DB::statement("ALTER TABLE design_layers MODIFY COLUMN print_position ENUM('front', 'back', 'chest', 'shoulder') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE design_layers MODIFY COLUMN print_position ENUM('front', 'back', 'chest_left', 'chest_right', 'shoulder_left', 'shoulder_right') NOT NULL");
    }
};
