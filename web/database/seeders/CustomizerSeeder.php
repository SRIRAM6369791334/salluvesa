<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customproduct;
use App\Models\ProductColor;
use App\Models\ProductColorImage;
use Illuminate\Support\Facades\DB;

class CustomizerSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Premium T-Shirt
        $product = Customproduct::updateOrCreate(
            ['name' => 'Premium Heavyweight Crewneck'],
            [
                'description' => '100% Ring-Spun Cotton, 220 GSM. Pre-shrunk and bio-washed for ultimate comfort.',
                'base_price' => 599.00,
                'product_type' => 'tshirt',
                'status' => 'active'
            ]
        );

        // 2. Add Colors and Mockups
        $colors = [
            ['name' => 'Midnight Black', 'code' => '#1a1a1a'],
            ['name' => 'Cloud White', 'code' => '#ffffff'],
            ['name' => 'Royal Navy', 'code' => '#002366'],
            ['name' => 'Heather Grey', 'code' => '#a9a9a9']
        ];

        foreach ($colors as $colorData) {
            $color = ProductColor::updateOrCreate(
                ['customproduct_id' => $product->id, 'color_name' => $colorData['name']],
                ['color_code' => $colorData['code'], 'status' => 'active']
            );

            // Mockup Image Views
            $views = ['front', 'back', 'chest', 'shoulder'];
            foreach ($views as $view) {
                // Using placeholder images that look like real t-shirts
                $placeholderUrl = "https://via.placeholder.com/800x1000/eeeeee/333333?text=" . urlencode($colorData['name'] . " " . $view);
                
                ProductColorImage::updateOrCreate(
                    ['product_color_id' => $color->id, 'view_type' => $view],
                    ['image_url' => $placeholderUrl]
                );
            }
        }

        // 3. Mark migrations as ran if needed (handled by fix script usually)
        
        $this->command->info('Customizer Seeding Completed Successfully!');
    }
}
