<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
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
            DB::table('products')->insert([
                    'name' => Str::random(3),
                    'amount' => 123456789,
                    'price' => 123456789,
                    'description' => Str::random(30),
                    'category_id' => $i,
                    'brand_id' => $i,
                    'status' => $status,
                    'image' => '',
            ]);
        }
    }
}
