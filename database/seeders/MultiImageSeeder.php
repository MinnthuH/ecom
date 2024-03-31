<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MultiImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('multi_imgs')->insert([
                'product_id' => rand(1, 10),
                'photo_name' => 'photo_' . ($i + 1) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
