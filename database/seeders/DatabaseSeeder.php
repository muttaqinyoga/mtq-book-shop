<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'name' => 'Owner Toko',
            'email' => 'administrator@muttaqin-shop.id',
            'password' => \Hash::make('admin62'),
            'username' => 'admin_toko',
            'roles' => '["ADMIN"]',
            'address' => 'Jalan Karet Gusuran III, Setiabudi, Jakarta Selatan',
            'phone' => '081273933586',
            'status' => 'ACTIVE'
        ]);
    }
}
