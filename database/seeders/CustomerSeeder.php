<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 2; $i++) {
            DB::table('customers')->insert([
                    'name' => Str::random(5),
                    'email' => Str::random(10) . '@gmail.com',
                    'password' => Hash::make('password'),
                    'phone' => Str::random(10),
                    'avatar' => Str::random(10),
            ]);
        }
    }
}
