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
            'user_id'       => 1,
            'file_name'     => 'test1.jpg',
            'title'         => 'Test Image 1',
            'description'   => 'This is the first test image.',
            'tag'           => 'C++',
            'media_type'    => 'image',
            'mime_type'     => 'image/jpeg'
        ]);

        DB::table('media')->insert([
            'user_id'       => 2,
            'file_name'     => 'test2.jpg',
            'title'         => 'Test Image 2',
            'description'   => 'This is the second test image.',
            'tag'           => 'C++',
            'media_type'    => 'image',
            'mime_type'     => 'image/jpeg'
        ]);

        DB::table('media')->insert([
            'user_id'       => 3,
            'file_name'     => 'test3.jpg',
            'title'         => 'Test Image 3',
            'description'   => 'This is the third test image.',
            'tag'           => 'PHP',
            'media_type'    => 'image',
            'mime_type'     => 'image/jpeg'
        ]);
    }
}
