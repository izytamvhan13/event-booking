<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('facilities')->insert([
            [
                'name' => 'LCD Proyektor & Layar',
                'photo' => 'lcd.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Monitor TV 55 Inch',
                'photo' => 'monitor.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Sound System & Mic Wireless',
                'photo' => 'sound.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Mimbar / Podium',
                'photo' => 'mimbar.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Panggung Mini (Stage)',
                'photo' => 'panggung.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Whiteboard & Spidol',
                'photo' => 'whiteboard.jpg',
                'created_at' => now(),
            ]
        ]);
    }
}