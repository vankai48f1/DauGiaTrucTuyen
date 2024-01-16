<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            [   'id' => Str::uuid()->toString(),
                'name' => '7',
                'path' => 'media',
                'file_name' => '_153ed25e-753d-45b9-809f-ebd2fb449780_.jpeg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => '22',
                'path' => 'media',
                'file_name' => '_2b70d0d5-b037-4659-a7e2-af47ce81d103_.png',
                'mime_type' => 'image/png',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => '44',
                'path' => 'media',
                'file_name' => '_2dac7c40-5112-4649-aa6b-ed53dd702667_.png',
                'mime_type' => 'image/png',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => '3',
                'path' => 'media',
                'file_name' => '_61ec4643-79ed-4343-acd0-fe333e914950_.jpeg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => '33',
                'path' => 'media',
                'file_name' => '_72c33549-536c-481a-934f-daf3a4da8597_.png',
                'mime_type' => 'image/png',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => '11',
                'path' => 'media',
                'file_name' => '_792ccd8e-3bb8-4a45-a499-2a79a08e286b_.png',
                'mime_type' => 'image/png',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => '2',
                'path' => 'media',
                'file_name' => '_8509bc0b-20a2-4f90-b5a5-807d52018084_.jpeg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => '160x40-logo',
                'path' => 'media',
                'file_name' => '_b5abaabd-5ece-43ee-982c-00de63778e1c_.png',
                'mime_type' => 'image/png',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => '4',
                'path' => 'media',
                'file_name' => '_b5ea53b7-9a05-4ccc-bccc-69688dd6056a_.jpeg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now()
            ],

        ];
        DB::table('media')->insert($input);
    }
}
