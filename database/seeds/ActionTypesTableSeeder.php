<?php

use Illuminate\Database\Seeder;

class ActionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('action_types')->insert([
            ['name' => 'GET'],
            ['name' => 'POST'],
            ['name' => 'PUT'],
            ['name' => 'DELETE'],
            ['name' => 'HEAD'],
            ['name' => 'OPTONS'],
            ['name' => 'TRACE'],
            ['name' => 'CONNECT'],
            ['name' => 'PATCH']
        ]);
    }
}
