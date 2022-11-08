<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 2; $i++) {
            $status = 0;
            if($i%2==0){
                $status=1;
            }
            DB::table('order_details')->insert([
                    'product_price' => Str::random(10),
                    'product_quantity' => Str::random(10),
                    'product_total_quantity' => Str::random(10),
                    'product_id' => $i,
                    'order_id' => $i,
            ]);
        }
    }
}
