<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 2; $i++) {
            DB::table('orders')->insert([
                    'note' => Str::random(3),
                    'address' => Str::random(3),
                    'order_total_price' => Str::random(3),
                    'customer_id' => $i,
            ]);
        }
    }
}
