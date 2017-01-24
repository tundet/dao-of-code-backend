<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'user_id'       => 1,
            'medium_id'     => 2,
            'comment'       => 'The first comment.',
        ]);

        DB::table('comments')->insert([
            'user_id'       => 2,
            'medium_id'     => 3,
            'comment'       => 'The second comment.',
        ]);

        DB::table('comments')->insert([
            'user_id'       => 3,
            'medium_id'     => 1,
            'comment'       => 'The third comment.',
        ]);
    }
}
