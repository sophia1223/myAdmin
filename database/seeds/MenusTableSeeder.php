<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'id' => 1,
                'p_id' => 0,
                'permission_id' => 0,
                'name' => '后台管理',
                'icon' => 'fa fa-home',
                'sort' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 2,
                'p_id' => 1,
                'permission_id' => 1,
                'name' => '菜单管理',
                'icon' => 'fa fa-bars',
                'sort' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
