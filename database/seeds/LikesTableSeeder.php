<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('likes')->insert([
            'user_id'       => 1,
            'medium_id'     => 2,
            'like'          => 1
        ]);

        DB::table('likes')->insert([
            'user_id'       => 2,
            'medium_id'     => 3,
            'like'          => 0
        ]);

        DB::table('likes')->insert([
            'user_id'       => 3,
            'medium_id'     => 1,
            'like'          => 1
        ]);

        DB::table('likes')->insert([
            'user_id'       => 1,
            'group_id'      => 2,
            'like'          => 1
        ]);

        DB::table('likes')->insert([
            'user_id'       => 2,
            'group_id'      => 3,
            'like'          => 0
        ]);

        DB::table('likes')->insert([
            'user_id'       => 3,
            'group_id'      => 1,
            'like'          => 1
        ]);
    }
}
