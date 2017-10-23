<?php

use Illuminate\Database\Seeder;

class NewsTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news_types')->insert([
            ['name' => '时事要闻'],
            ['name' => '文件公告'],
            ['name' => '合作交流']
        ]);
    }
}
