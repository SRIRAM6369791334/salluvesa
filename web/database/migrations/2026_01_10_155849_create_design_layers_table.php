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
        if (!Schema::hasTable('design_layers')) {
            Schema::create('design_layers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('design_id')->constrained('customproduct_designs')->onDelete('cascade');
                $table->enum('layer_type', ['text', 'image', 'icon']);
                $table->text('text_content')->nullable(); // For text layers
                $table->decimal('x_position', 10, 2);
                $table->decimal('y_position', 10, 2);
                $table->decimal('width', 10, 2);
                $table->decimal('height', 10, 2);
                $table->decimal('rotation', 8, 2)->default(0);
                $table->decimal('scale_x', 8, 2)->default(1);
                $table->decimal('scale_y', 8, 2)->default(1);
                $table->enum('print_position', ['front', 'back']);
                $table->integer('z_index')->default(0);
                $table->json('layer_json')->nullable(); // Full Fabric.js object JSON
                $table->timestamps();

                // Indexes for performance
                $table->index('design_id');
                $table->index('print_position');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_layers');
    }
};
