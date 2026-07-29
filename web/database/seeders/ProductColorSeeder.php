<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductColor;
use App\Models\ProductColorImage;

class ProductColorSeeder extends Seeder
{
    public function run(): void
    {
        // Add color variant for Premium White T-Shirt (ID 1)
        $whiteColor = ProductColor::create([
            'customproduct_id' => 1,
            'color_name' => 'White',
            'color_code' => '#FFFFFF',
            'status' => 'active',
        ]);

        ProductColorImage::create([
            'product_color_id' => $whiteColor->id,
            'view_type' => 'front',
            'image_url' => 'img/tshirt-front.png',
        ]);

        ProductColorImage::create([
            'product_color_id' => $whiteColor->id,
            'view_type' => 'back',
            'image_url' => 'img/tshirt-back.png',
        ]);

        // Add color variant for Premium Black T-Shirt (ID 2)
        $blackColor = ProductColor::create([
            'customproduct_id' => 2,
            'color_name' => 'Black',
            'color_code' => '#1a1a1a',
            'status' => 'active',
        ]);

        ProductColorImage::create([
            'product_color_id' => $blackColor->id,
            'view_type' => 'front',
            'image_url' => 'img/tshirt-black-front.png',
        ]);

        ProductColorImage::create([
            'product_color_id' => $blackColor->id,
            'view_type' => 'back',
            'image_url' => 'img/tshirt-black-back.png',
        ]);

        // Add color variant for Custom Hoodie (ID 3) - Gray
        $grayColor = ProductColor::create([
            'customproduct_id' => 3,
            'color_name' => 'Gray',
            'color_code' => '#808080',
            'status' => 'active',
        ]);

        ProductColorImage::create([
            'product_color_id' => $grayColor->id,
            'view_type' => 'front',
            'image_url' => 'img/product1.png',
        ]);
    }
}
