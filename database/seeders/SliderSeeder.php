<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {

            DB::table('sliders')->insert([
                'slider_title' => 'Slider title ' . ($i + 1),
                'short_title' => 'Slider-Short-title ' . ($i + 1),
                'slider_image' => 'image' . ($i + 1) . '.jpg',
            ]);
        }
    }
}
