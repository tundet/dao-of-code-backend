<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            "username"  => "user1",
            "email"     => "user1@example.com",
            "password"  => Hash::make("user1")
        ]);

        DB::table("users")->insert([
            "username"  => "user2",
            "email"     => "user2@example.com",
            "password"  => Hash::make("user2")
        ]);
    }
}
