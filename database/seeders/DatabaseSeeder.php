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
        \App\Models\User::create([
            'name' => 'Nurtria Ningsih',
            'email' => 'ntrningsih@muttaqin-shop.id',
            'password' => \Hash::make('bubby123'),
            'username' => 'nurtria_ningsih',
            'roles' => '["CUSTOMER"]',
            'address' => 'Pasar 5B Kec. Hinai, Langkat, Sumatera Utara',
            'phone' => '082274956121',
            'status' => 'ACTIVE'
        ]);
        \App\Models\Category::create([
            'name' => 'Love Stories',
            'slug' => 'love-stories',
            'image' => 'categories/ZhDaCVcZ2fwMkCH49fKNugD6hItO13fVmmmQEjAt.jpg'
        ]);
        \App\Models\Category::create([
            'name' => 'Computer Science',
            'slug' => 'computer-science',
            'image' => 'categories/ImyOT1EE99fjsB8qo32qkKV4ZuLHNn0YhccBT0kH.jpg'
        ]);
        \App\Models\Category::create([
            'name' => 'Religion',
            'slug' => 'religion',
            'image' => 'categories/WMlcLgTPS37lYGC3EZQMaZ4F3HtU7tnGwTGsE9zi.png'
        ]);
        \App\Models\Category::create([
            'name' => 'Self Development',
            'slug' => 'self-development',
            'image' => 'categories/Y6AtWOLq4w4hsxcFrM2Jv9O19dZjzDKZ0oH93Ztg.jpg'
        ]);
    }
}
