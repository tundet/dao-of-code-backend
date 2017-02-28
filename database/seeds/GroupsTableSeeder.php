<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'user_id'     => 1,
            'name'        => 'My PHP Tutorials',
            'description' => 'Description for My PHP Tutorials',
            'tag'         => 'php'
        ]);

        DB::table('groups')->insert([
            'user_id'   => 1,
            'name'      => 'Useful JavaScript Code Snippets',
            'description' => 'Description for Useful JavaScript Code Snippets',
            'tag'       => 'javascript'
        ]);

        DB::table('groups')->insert([
            'user_id'  => 2,
            'name'     => 'Miscellaneous Tutorials',
            'description' => 'Description for "Miscellaneous Tutorials',
            'tag'  => 'cpp'
        ]);
    }
}
