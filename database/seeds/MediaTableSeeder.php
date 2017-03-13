<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('media')->insert([
            'user_id'        => 3,
            'group_id'       => 3,
            'title'          => 'What is PHP?',
            'description'    => 'PHP explained in 10 minutes.',
            'tag'            => 'php',
            'media_type'     => 'youtube',
            'youtube_url'    => 'https://www.youtube.com/embed/-oUXcTz1eEA',
            'group_priority' => 1
        ]);

        DB::table('media')->insert([
            'user_id'        => 3,
            'group_id'       => 3,
            'file_name'      => '5.jpg',
            'title'          => 'Learn PHP in 30 minutes',
            'description'    => 'Learn the basics of PHP in just 30 minutes!',
            'tag'            => 'php',
            'media_type'     => 'youtube',
            'youtube_url'    => 'https://www.youtube.com/embed/7TF00hJI78Y',
            'group_priority' => 2
        ]);

        DB::table('media')->insert([
            'user_id'        => 3,
            'group_id'       => 3,
            'title'          => 'Laravel Podcast #26',
            'description'    => 'Discussing Laravel 5.3.8, Spark 2 and Lumen 5.3.',
            'tag'            => 'php',
            'media_type'     => 'youtube',
            'youtube_url'    => 'https://www.youtube.com/embed/2m7IY-Xb6Og',
            'group_priority' => 3
        ]);
    }
}
