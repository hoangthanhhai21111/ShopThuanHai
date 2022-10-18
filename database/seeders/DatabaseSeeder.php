<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            CustomerSeeder::class,
            BrandSeeder::class,
            OrderSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderDetailSeeder::class,
            BannerSeeder::class
        ]);
    }
}
