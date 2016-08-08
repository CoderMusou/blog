<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '百度',
                'link_title' => '国内一般的搜索引擎',
                'link_url' => 'http://www.baidu.com',
                'link_order' => 1,
            ],
            [
                'link_name' => '百度贴吧',
                'link_title' => '国内最大的论坛贴吧',
                'link_url' => 'http://tieba.baidu.com',
                'link_order' => 2,
            ],
        ];
        DB::table('links')->insert($data);
    }
}
