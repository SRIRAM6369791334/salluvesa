<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customproduct;
use App\Models\ProductColor;
use App\Models\ProductColorImage;

class CustomProductSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for truncation
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing to avoid duplicates
        Customproduct::truncate();
        ProductColor::truncate();
        ProductColorImage::truncate();
        
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Premium T-Shirt with colors
        $tshirt = Customproduct::create([
            'name' => 'Premium Cotton T-Shirt',
            'description' => 'A high-quality 100% cotton t-shirt, perfect for your custom designs.',
            'base_price' => 499.00,
            'product_type' => 'tshirt',
            'status' => 'active',
            'front_mockup' => 'img/tshirt-front.png',
            'back_mockup' => 'img/tshirt-back.png',
            'right_shoulder_mockup' => 'img/tshirt-right-shoulder.png',
            'left_shoulder_mockup' => 'img/tshirt-left-shoulder.png',
            'printable_rect' => [
                'x' => 150,
                'y' => 100,
                'width' => 200,
                'height' => 350
            ],
            'is_two_sided' => true,
            'available_sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
            'canvas_config' => [
                'width' => 800,
                'height' => 900
            ]
        ]);

        // White T-Shirt Color
        $white = ProductColor::create([
            'customproduct_id' => $tshirt->id,
            'color_name' => 'White',
            'color_code' => '#ffffff',
            'status' => 'active'
        ]);

        ProductColorImage::create([
            'product_color_id' => $white->id,
            'view_type' => 'front',
            'image_path' => 'img/tshirt-front.png'
        ]);

        ProductColorImage::create([
            'product_color_id' => $white->id,
            'view_type' => 'back',
            'image_path' => 'img/tshirt-back.png'
        ]);

        ProductColorImage::create([
            'product_color_id' => $white->id,
            'view_type' => 'right-shoulder',
            'image_path' => 'img/tshirt-right-shoulder.png'  // Placeholder for now
        ]);

        ProductColorImage::create([
            'product_color_id' => $white->id,
            'view_type' => 'left-shoulder',
            'image_path' => 'img/tshirt-left-shoulder.png'   // Placeholder for now
        ]);

        // Black T-Shirt Color
        $black = ProductColor::create([
            'customproduct_id' => $tshirt->id,
            'color_name' => 'Black',
            'color_code' => '#000000',
            'status' => 'active'
        ]);

        ProductColorImage::create([
            'product_color_id' => $black->id,
            'view_type' => 'front',
            'image_path' => 'img/tshirt-black-front.png'
        ]);

        ProductColorImage::create([
            'product_color_id' => $black->id,
            'view_type' => 'back',
            'image_path' => 'img/tshirt-black-back.png'
        ]);

        ProductColorImage::create([
            'product_color_id' => $black->id,
            'view_type' => 'right-shoulder',
            'image_path' => 'img/tshirt-black-right-shoulder.png' // Placeholder
        ]);

        ProductColorImage::create([
            'product_color_id' => $black->id,
            'view_type' => 'left-shoulder',
            'image_path' => 'img/tshirt-black-left-shoulder.png'  // Placeholder
        ]);

        // Create Custom Hoodie with colors
        $hoodie = Customproduct::create([
            'name' => 'Custom Hoodie',
            'description' => 'Stay warm and stylish with a custom-designed hoodie. Durable and comfortable.',
            'base_price' => 999.00,
            'product_type' => 'hoodie',
            'status' => 'active',
            'front_mockup' => 'img/product1.png',
            'back_mockup' => null,
            'printable_rect' => [
                'x' => 150,
                'y' => 120,
                'width' => 200,
                'height' => 300
            ],
            'is_two_sided' => false,
            'available_sizes' => ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
            'canvas_config' => [
                'width' => 900,
                'height' => 1000
            ]
        ]);

        // Gray Hoodie Color
        $gray = ProductColor::create([
            'customproduct_id' => $hoodie->id,
            'color_name' => 'Gray',
            'color_code' => '#6b7280',
            'status' => 'active'
        ]);

        ProductColorImage::create([
            'product_color_id' => $gray->id,
            'view_type' => 'front',
            'image_path' => 'img/product1.png'
        ]);

        $this->command->info('Custom Products with colors seeded successfully!');
    }
}
