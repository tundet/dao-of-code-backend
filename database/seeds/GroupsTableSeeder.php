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
            'user_id'   => 1,
            'name'      => 'My PHP Tutorials',
            'tag'       => 'PHP'
        ]);

        DB::table('groups')->insert([
            'user_id'  => 2,
            'name'     => 'Miscellaneous Tutorials',
            'tag'  => 'C++'
        ]);
    }
}