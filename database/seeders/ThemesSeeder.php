<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Sites\Models\Theme;

class ThemesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Deluxe','advision_deluxe'],
            [2,'Palisades','palisades']
        ];
        $fields = ['id','name','folder'];

        foreach ($rows as $row) {
            Theme::create(array_combine($fields, $row));
        }
    }
}
