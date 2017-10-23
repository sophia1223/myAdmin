<?php

use Illuminate\Database\Seeder;

class RolesAdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_admins')->insert([
            'role_id' => 1,
            'admin_id' => 1
        ]);
    }
}
