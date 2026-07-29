<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShopDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        // 1. Seed Categories
        DB::table('categories')->insertOrIgnore([
            ['id' => 1, 'category_name' => 'Men', 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'category_name' => 'Women', 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'category_name' => 'Children', 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 2. Seed Sub Categories
        DB::table('sub_categories')->insertOrIgnore([
            ['id' => 1, 'subcategory_name' => 'T-Shirts', 'category_name' => 1, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'subcategory_name' => 'Shirts (Formal)', 'category_name' => 1, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'subcategory_name' => 'Jeans', 'category_name' => 1, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'subcategory_name' => 'Dresses', 'category_name' => 2, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'subcategory_name' => 'Tops', 'category_name' => 2, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 3. Seed Products
        DB::table('products')->insertOrIgnore([
            [
                'id' => 1,
                'category_id' => 1,
                'subcategory_id' => 1,
                'product_name' => 'Pure black cotton men T-shirt',
                'prod_unique_name' => 'pure-black-cotton-men-tshirt',
                'product_quantity' => 10,
                'product_mrp_price' => 250.00,
                'product_description' => 'Our men black t-shirt offers a classic fit and is made from high-quality pure cotton materials to keep you feeling and looking great.',
                'product_image' => 'img/product1.png',
                'product_specification' => 'Material: Cotton | Fit: Regular',
                'product_specfication' => 'Material: Cotton | Fit: Regular',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'subcategory_id' => 1,
                'product_name' => 'Gray color cotton men T-shirt',
                'prod_unique_name' => 'gray-color-cotton-men-tshirt',
                'product_quantity' => 15,
                'product_mrp_price' => 220.00,
                'product_description' => 'A versatile gray t-shirt for everyday wear.',
                'product_image' => 'img/product2.png',
                'product_specification' => 'Material: Cotton | Fit: Slim',
                'product_specfication' => 'Material: Cotton | Fit: Slim',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'subcategory_id' => 5,
                'product_name' => 'Velvet touch women tops',
                'prod_unique_name' => 'velvet-touch-women-tops',
                'product_quantity' => 5,
                'product_mrp_price' => 750.00,
                'product_description' => 'Premium velvet touch women top.',
                'product_image' => 'img/product7.png',
                'product_specification' => 'Material: Velvet | Fit: Regular',
                'product_specfication' => 'Material: Velvet | Fit: Regular',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'category_id' => 1,
                'subcategory_id' => 2,
                'product_name' => 'Men casual check shirt',
                'prod_unique_name' => 'men-casual-check-shirt',
                'product_quantity' => 20,
                'product_mrp_price' => 350.00,
                'product_description' => 'An awesome casual check shirt.',
                'product_image' => 'img/product26.png',
                'product_specification' => 'Material: Cotton | Sleeve: Full',
                'product_specfication' => 'Material: Cotton | Sleeve: Full',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
