<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
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
            DB::table('banners')->insert([
                    'avatar' => Str::random(10),
                    'url' => Str::random(10),
                    'status' => $status,
            ]);
        }
    }
}
