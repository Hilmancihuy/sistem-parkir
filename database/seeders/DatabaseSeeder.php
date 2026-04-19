<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
   public function run(): void
{
    // Pastikan Anda memanggil RoleSeeder jika menggunakan Spatie Role
    $this->call(RoleSeeder::class); 

    // Membuat User Admin
    $admin = \App\Models\User::create([
        'name' => 'Admin Parkir',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password123'), // Ini adalah password Anda
    ]);
    
    // Memberikan role admin ke user (jika pakai Spatie)
    $admin->assignRole('admin');

    \App\Models\Category::create(['name' => 'Motor', 'price' => 2000]);
    \App\Models\Category::create(['name' => 'Mobil', 'price' => 5000]);

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
