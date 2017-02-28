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
            'user_id'        => 1,
            'group_id'       => 1,
            'file_name'      => '2.gif',
            'title'          => 'Test Image 1',
            'description'    => 'This is the first test image.',
            'tag'            => 'php',
            'media_type'     => 'image',
            'mime_type'      => 'image/gif',
            'group_priority' => 1
        ]);

        DB::table('media')->insert([
            'user_id'        => 2,
            'group_id'       => 2,
            'file_name'      => '2.gif',
            'title'          => 'Test Image 2',
            'description'    => 'This is the second test image.',
            'tag'            => 'javascript',
            'media_type'     => 'image',
            'mime_type'      => 'image/gif',
            'group_priority' => 1
        ]);

        DB::table('media')->insert([
            'user_id'        => 3,
            'group_id'       => 3,
            'file_name'      => '3.gif',
            'title'          => 'Test Image 3',
            'description'    => 'This is the third test image.',
            'tag'            => 'cpp',
            'media_type'     => 'image',
            'mime_type'      => 'image/gif',
            'group_priority' => 1
        ]);

        DB::table('media')->insert([
            'user_id'        => 3,
            'group_id'       => 3,
            'file_name'      => '4.png',
            'title'          => 'Test Image 3',
            'description'    => 'This is the third test image.',
            'tag'            => 'cpp',
            'media_type'     => 'image',
            'mime_type'      => 'image/png',
            'group_priority' => 2
        ]);

        DB::table('media')->insert([
            'user_id'        => 3,
            'group_id'       => 3,
            'file_name'      => '5.jpg',
            'title'          => 'Test Image 3',
            'description'    => 'This is the third test image.',
            'tag'            => 'cpp',
            'media_type'     => 'image',
            'mime_type'      => 'image/jpeg',
            'group_priority' => 3
        ]);
    }
}
