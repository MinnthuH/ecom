<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {

            $categoryName = 'Category' . ($i + 1);
            $categorySlug = Str::slug($categoryName);

            DB::table('categories')->insert([
                'name' => $categoryName,
                'slug' => $categorySlug,
                'image' => 'image' . ($i + 1) . '.jpg',
            ]);
        }
    }
}
