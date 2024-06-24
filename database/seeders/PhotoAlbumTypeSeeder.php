<?php

namespace Database\Seeders;

use Domain\Photos\Models\PhotoAlbumType;
use Illuminate\Database\Seeder;

class PhotoAlbumTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1, 'User'],
            [2, 'Product'],
            [3, 'Group'],
            [4, 'Articles'],
            [5, 'Events'],
            [7, 'Advertising'],
        ];
        $fields = ['id', 'name'];

        foreach ($rows as $row) {
            PhotoAlbumType::create(array_combine($fields, $row));
        }
    }
}
