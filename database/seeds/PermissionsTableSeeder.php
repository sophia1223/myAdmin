<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                "id" => 1,
                "name" => "菜单管理",
                "remark" => null,
                "controller" => "MenuController",
                "method" => "index",
                "action_type_ids" => "1,5",
                "route" => "admin/menus/index",
                "alias" => "admin.menus.index",
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ]
        ]);
    }
}
