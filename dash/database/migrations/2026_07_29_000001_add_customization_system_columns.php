<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Add columns to customproducts table if exists
        if (Schema::hasTable('customproducts')) {
            Schema::table('customproducts', function (Blueprint $table) {
                if (!Schema::hasColumn('customproducts', 'is_customizable')) {
                    $table->tinyInteger('is_customizable')->default(1);
                }
                if (!Schema::hasColumn('customproducts', 'embroidery_price')) {
                    $table->decimal('embroidery_price', 10, 2)->default(150.00);
                }
                if (!Schema::hasColumn('customproducts', 'printing_price')) {
                    $table->decimal('printing_price', 10, 2)->default(100.00);
                }
                if (!Schema::hasColumn('customproducts', 'text_only_price')) {
                    $table->decimal('text_only_price', 10, 2)->default(75.00);
                }
            });
        }

        // 1b. Add columns to product_varient table if exists
        $variantTable = Schema::hasTable('product_varient') ? 'product_varient' : (Schema::hasTable('product_variants') ? 'product_variants' : null);
        if ($variantTable) {
            Schema::table($variantTable, function (Blueprint $table) use ($variantTable) {
                if (!Schema::hasColumn($variantTable, 'is_customizable')) {
                    $table->tinyInteger('is_customizable')->default(0);
                }
                if (!Schema::hasColumn($variantTable, 'front_view_img')) {
                    $table->string('front_view_img', 255)->nullable();
                }
                if (!Schema::hasColumn($variantTable, 'back_view_img')) {
                    $table->string('back_view_img', 255)->nullable();
                }
                if (!Schema::hasColumn($variantTable, 'left_view_img')) {
                    $table->string('left_view_img', 255)->nullable();
                }
                if (!Schema::hasColumn($variantTable, 'right_view_img')) {
                    $table->string('right_view_img', 255)->nullable();
                }
                if (!Schema::hasColumn($variantTable, 'placement_config')) {
                    $table->longText('placement_config')->nullable();
                }
                if (!Schema::hasColumn($variantTable, 'embroidery_price')) {
                    $table->decimal('embroidery_price', 10, 2)->default(0.00);
                }
                if (!Schema::hasColumn($variantTable, 'printing_price')) {
                    $table->decimal('printing_price', 10, 2)->default(0.00);
                }
                if (!Schema::hasColumn($variantTable, 'text_only_price')) {
                    $table->decimal('text_only_price', 10, 2)->default(0.00);
                }
            });
        }

        // 2. Add columns to carts table
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                if (!Schema::hasColumn('carts', 'customization_type')) {
                    $table->string('customization_type', 50)->default('none');
                }
                if (!Schema::hasColumn('carts', 'customization_method')) {
                    $table->string('customization_method', 255)->default('none');
                }
                if (!Schema::hasColumn('carts', 'customization_position')) {
                    $table->string('customization_position', 255)->default('none');
                }
                if (!Schema::hasColumn('carts', 'custom_text')) {
                    $table->string('custom_text', 100)->nullable();
                }
                if (!Schema::hasColumn('carts', 'custom_text_color')) {
                    $table->string('custom_text_color', 50)->nullable();
                }
                if (!Schema::hasColumn('carts', 'custom_logo_url')) {
                    $table->string('custom_logo_url', 1024)->nullable();
                }
                if (!Schema::hasColumn('carts', 'embroidery_icon_id')) {
                    $table->unsignedBigInteger('embroidery_icon_id')->nullable();
                }
                if (!Schema::hasColumn('carts', 'custom_instructions')) {
                    $table->text('custom_instructions')->nullable();
                }
                if (!Schema::hasColumn('carts', 'customization_price')) {
                    $table->decimal('customization_price', 10, 2)->default(0.00);
                }
                if (!Schema::hasColumn('carts', 'preview_screenshot_url')) {
                    $table->string('preview_screenshot_url', 255)->nullable();
                }
            });
        }

        // 3. Add columns to product_slots table
        if (Schema::hasTable('product_slots')) {
            Schema::table('product_slots', function (Blueprint $table) {
                if (!Schema::hasColumn('product_slots', 'customization_type')) {
                    $table->string('customization_type', 50)->default('none');
                }
                if (!Schema::hasColumn('product_slots', 'customization_method')) {
                    $table->string('customization_method', 255)->default('none');
                }
                if (!Schema::hasColumn('product_slots', 'customization_position')) {
                    $table->string('customization_position', 255)->default('none');
                }
                if (!Schema::hasColumn('product_slots', 'custom_text')) {
                    $table->string('custom_text', 100)->nullable();
                }
                if (!Schema::hasColumn('product_slots', 'custom_text_color')) {
                    $table->string('custom_text_color', 50)->nullable();
                }
                if (!Schema::hasColumn('product_slots', 'custom_logo_url')) {
                    $table->string('custom_logo_url', 1024)->nullable();
                }
                if (!Schema::hasColumn('product_slots', 'embroidery_icon_id')) {
                    $table->unsignedBigInteger('embroidery_icon_id')->nullable();
                }
                if (!Schema::hasColumn('product_slots', 'custom_instructions')) {
                    $table->text('custom_instructions')->nullable();
                }
                if (!Schema::hasColumn('product_slots', 'customization_price')) {
                    $table->decimal('customization_price', 10, 2)->default(0.00);
                }
                if (!Schema::hasColumn('product_slots', 'preview_screenshot_url')) {
                    $table->string('preview_screenshot_url', 255)->nullable();
                }
                if (!Schema::hasColumn('product_slots', 'mockup_url')) {
                    $table->string('mockup_url', 255)->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $variantTable = Schema::hasTable('product_varient') ? 'product_varient' : (Schema::hasTable('product_variants') ? 'product_variants' : null);
        if ($variantTable) {
            Schema::table($variantTable, function (Blueprint $table) use ($variantTable) {
                $cols = ['is_customizable', 'front_view_img', 'back_view_img', 'left_view_img', 'right_view_img', 'placement_config', 'embroidery_price', 'printing_price', 'text_only_price'];
                foreach ($cols as $col) {
                    if (Schema::hasColumn($variantTable, $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                $cols = ['customization_type', 'customization_method', 'customization_position', 'custom_text', 'custom_text_color', 'custom_logo_url', 'embroidery_icon_id', 'custom_instructions', 'customization_price', 'preview_screenshot_url'];
                foreach ($cols as $col) {
                    if (Schema::hasColumn('carts', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('product_slots')) {
            Schema::table('product_slots', function (Blueprint $table) {
                $cols = ['customization_type', 'customization_method', 'customization_position', 'custom_text', 'custom_text_color', 'custom_logo_url', 'embroidery_icon_id', 'custom_instructions', 'customization_price', 'preview_screenshot_url', 'mockup_url'];
                foreach ($cols as $col) {
                    if (Schema::hasColumn('product_slots', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
