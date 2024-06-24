<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Sites\Models\Layout\DisplayTemplateType;

class DisplayTemplatesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Category Thumbnail'],
            [2,'Product Thumbnail'],
            [3,'Product Detail'],
            [4,'Product Zoom']
        ];
        $fields = ['id','name'];

        foreach ($rows as $row) {
            DisplayTemplateType::create(array_combine($fields, $row));
        }
    }
}
