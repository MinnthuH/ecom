<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 0; $i < 5; $i++) {
            $subcategoryName = 'Sub-Category' . ($i + 1);
            $subcategorySlug = Str::slug($subcategoryName);

            DB::table('sub_categories')->insert([
                'category_id' => rand(1, 5),
                'subcategory_name' => $subcategoryName,
                'subcategory_slug' => $subcategorySlug,
            ]);
        }
    }
}
