<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {

            DB::table('banners')->insert([
                'banner_title' => 'Banner' . ($i + 1),
                'banner_url' => 'https://stackoverflow.com',
                'banner_image' => 'image' . ($i + 1) . '.jpg',
            ]);
        }
    }
}
