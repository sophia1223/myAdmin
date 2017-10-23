<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        $this->call(ActionTypesTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(NewsTypesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesAdminsTableSeeder::class);
        $this->call(RolesPermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}
