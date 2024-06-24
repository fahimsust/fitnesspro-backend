<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Sites\Models\Layout\Layout;

class LayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'None','none'],
            [2,'One Column','onecolumn'],
            [3,'Two Column (Left)','twocolumn_left'],
            [4,'Two Column (Right)','twocolumn_right'],
            [5,'Three Column','threecolumn'],
            [6,'Home','home'],
            [7,'Offline','offline']
        ];
        $fields = ['id','name','file'];

        foreach ($rows as $row) {
            Layout::create(array_combine($fields, $row));
        }
    }
}
