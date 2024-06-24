<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Sites\Models\Layout\DisplayTemplate;

class DisplayTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,1,'Default','default','150','100'],
            [2,2,'Default','default','150','0'],
            [3,3,'Default','default','300',''],
            [4,2,'List','list','',''],
            [7,1,'Text Only (no image)','textonly','',''],
            [8,2,'Featured','featured','',''],
            [9,2,'Featured Quarter','featuredqtr','',''],
            [10,3,'Thumbnail','thumbnail','250','250']
        ];
        $fields = ['id','type_id','name','include','image_width','image_height'];

        foreach ($rows as $row) {
            DisplayTemplate::create(array_combine($fields, $row));
        }
    }
}
