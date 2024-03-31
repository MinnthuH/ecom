<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            $brandName = 'Brand' . ($i + 1);
            $brandSlug = Str::slug($brandName);

            DB::table('brands')->insert([
                'name' => $brandName,
                'slug' => $brandSlug,
                'image' => 'image' . ($i + 1) . '.jpg',
            ]);
        }
    }
}
