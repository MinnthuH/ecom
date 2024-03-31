<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate dummy data and insert into the products table
        for ($i = 0; $i < 10; $i++) {
            DB::table('products')->insert([
                'brand_id' => rand(1, 5),
                'category_id' => rand(1, 5),
                'subcategory_id' => rand(1, 20),
                'product_name' => 'Product ' . ($i + 1),
                'product_slug' => 'product-' . ($i + 1),
                'product_code' => 'CODE' . ($i + 1),
                'product_qty' => rand(1, 100),
                'product_tags' => 'new product, top product',
                'product_size' => 'small, medium, large',
                'product_color' => 'red, blue, green',
                'selling_price' => rand(50, 500),
                'discount_price' => rand(0, 50),
                'short_descp' => 'Short description for product ' . ($i + 1),
                'long_descp' => 'Long description for product ' . ($i + 1),
                'product_thambnail' => 'thumbnail_' . ($i + 1) . '.jpg',
                'vendor_id' => rand(1, 3),
                'hot_deals' => rand(0, 1),
                'featured' => rand(0, 1),
                'special_offer' => rand(0, 1),
                'special_deals' => rand(0, 1),
                'status' => 1,
            ]);
        }
    }
}
