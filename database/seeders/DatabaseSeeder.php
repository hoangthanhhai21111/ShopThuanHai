<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->importRoles();
        $this->importPositions();
        $this->importPositionRole();
        $this->importPositionRole();
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
    public function importRoles()
    {
        $groups = ['Banner','Brand','Category','Customer','Group','Order','OrderDetail','Product','User'];
        $actions = ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'];
        foreach ($groups as $group) {
            foreach ($actions as $action) {
                DB::table('roles')->insert([
                    'name' => $group . '_' . $action,
                    'group_name' => $group,

                ]);
            }
        }
    }
    public function importPositions()
    {
        $userGroup = new Group();
        $userGroup->name = 'Supper Admin';
        $userGroup->description = 'Supper Admin';
        $userGroup->save();

        $userGroup = new Group();
        $userGroup->name = 'Quản Lý';
        $userGroup->description = 'Quản Lý';

        $userGroup->save();

        $userGroup = new Group();
        $userGroup->name = 'Giám Đốc';
        $userGroup->description = 'Giám Đốc';

        $userGroup->save();


        $userGroup = new Group();
        $userGroup->name = 'Nhân Viên';
        $userGroup->description = 'Nhân Viên';

        $userGroup->save();
    }
    public function importPositionRole()
    {
        for ($i = 1; $i <= 91; $i++) {
            DB::table('group_roles')->insert([
                'group_id' => 1,
                'role_id' => $i,
            ]);
        }
    }
}
