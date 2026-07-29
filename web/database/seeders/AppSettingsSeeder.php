<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppSetting;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            // Normal Users
            [
                'user_type' => 'Normal',
                'product_type' => 'Own Design',
                'min_quantity' => 1,
                'max_quantity' => 100,
            ],
            [
                'user_type' => 'Normal',
                'product_type' => 'Own Custom',
                'min_quantity' => 1,
                'max_quantity' => 100,
            ],
            [
                'user_type' => 'Normal',
                'product_type' => 'Bulk Custom',
                'min_quantity' => 50,
                'max_quantity' => 10000,
            ],
            [
                'user_type' => 'Normal',
                'product_type' => 'Sample',
                'min_quantity' => 1,
                'max_quantity' => 10,
            ],

            // B2B Users
            [
                'user_type' => 'B2B',
                'product_type' => 'Own Design',
                'min_quantity' => 1,
                'max_quantity' => 500,
            ],
            [
                'user_type' => 'B2B',
                'product_type' => 'Own Custom',
                'min_quantity' => 1,
                'max_quantity' => 500,
            ],
            [
                'user_type' => 'B2B',
                'product_type' => 'Bulk Custom',
                'min_quantity' => 100,
                'max_quantity' => 50000,
            ],
            [
                'user_type' => 'B2B',
                'product_type' => 'Sample',
                'min_quantity' => 1,
                'max_quantity' => 20,
            ],
        ];

        foreach ($settings as $setting) {
            AppSetting::updateOrCreate(
                [
                    'user_type' => $setting['user_type'],
                    'product_type' => $setting['product_type']
                ],
                $setting
            );
        }
    }
}
