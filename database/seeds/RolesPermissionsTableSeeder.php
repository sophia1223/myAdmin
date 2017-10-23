<?php

use Illuminate\Database\Seeder;

class RolesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_permissions')->insert([
            [
                "id" => 1,
                "role_id" => 1,
                "permission_id" => 1
            ]
        ]);
    }
}
