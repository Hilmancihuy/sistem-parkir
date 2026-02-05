<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
{
    \App\Models\ParkingSlot::create([
        'type' => 'motor',
        'capacity' => 100,
        'used' => 0
    ]);

    \App\Models\ParkingSlot::create([
        'type' => 'mobil',
        'capacity' => 50,
        'used' => 0
    ]);
}
}
