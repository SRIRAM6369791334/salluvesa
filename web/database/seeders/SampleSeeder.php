<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sample;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'title' => 'Premium T-Shirts',
                'category' => 'Essentials',
                'description' => '100% premium cotton fabric with superior comfort',
                'image' => 'img/sample.png',
                'badge' => 'Premium',
                'badge_type' => '',
                'price' => 250.00,
                'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                'features' => ['Breathable', 'Soft Touch'],
                'sort_order' => 1,
            ],
            [
                'title' => 'Polo T-Shirts',
                'category' => 'Sportswear',
                'description' => 'Classic polo design with modern athletic fit',
                'image' => 'img/sample1.png',
                'badge' => 'Popular',
                'badge_type' => 'popular',
                'price' => 300.00,
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'features' => ['Moisture-wicking', 'Durable'],
                'sort_order' => 2,
            ],
            [
                'title' => 'Formal Shirts',
                'category' => 'Business',
                'description' => 'Professional elegance meets exceptional comfort',
                'image' => 'img/sample2.png',
                'badge' => 'Exclusive',
                'badge_type' => 'exclusive',
                'price' => 350.00,
                'sizes' => ['M', 'L', 'XL', 'XXL'],
                'features' => ['Wrinkle-free', 'Premium'],
                'sort_order' => 3,
            ],
            [
                'title' => 'Tank Tops',
                'category' => 'Activewear',
                'description' => 'Lightweight and flexible for active lifestyles',
                'image' => 'img/sample3.png',
                'badge' => 'New',
                'badge_type' => '',
                'price' => 200.00,
                'sizes' => ['XS', 'S', 'M', 'L'],
                'features' => ['Stretchy', 'Quick-dry'],
                'sort_order' => 4,
            ],
        ];

        foreach ($samples as $sample) {
            Sample::updateOrCreate(['title' => $sample['title']], $sample);
        }
    }
}
