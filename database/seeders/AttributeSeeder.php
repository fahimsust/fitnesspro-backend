<?php

namespace Database\Seeders;

use Domain\Products\Models\Attribute\Attribute;

class AttributeSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            Attribute::class,
            ['id', 'name', 'type_id', 'show_in_details', 'show_in_search'],
            [
                [1, 'Country', 1, 1, 1],
                [2, 'Specialty', 2, 1, 1],
                [3, 'Size', 1, 1, 1],
                [4, 'Color', 1, 1, 1],
                [5, 'Cloth Material', 1, 1, 1],
                [6, 'Clothing Type', 1, 0, 1],
                [7, 'Ed Delivery Mode', 1, 1, 1],
                [8, 'CEC Eligible', 2, 1, 1],
                [9, 'Ed Specialty', 2, 1, 1],
                [10, 'Weight', 1, 1, 1],
                [11, 'Ex Goal', 1, 1, 1],
                [12, 'Ex Mode', 1, 0, 1],
                [13, 'Supplement Form', 1, 0, 1],
                [14, 'Supplement Target', 2, 1, 1],
                [15, 'B&B Type', 1, 1, 1],
                [16, 'Aroma', 1, 1, 1],
                [17, 'B&B Goal', 1, 1, 1],
                [18, 'Age Requirement', 1, 1, 1],
                [19, 'Weekly Number Fit Pros', 1, 1, 1],
                [20, 'Level', 2, 1, 1],
                [21, 'Resort', 1, 1, 1],
                [22, 'Region', 1, 1, 1],
                [23, 'Airport', 1, 1, 1],
            ]
        );
    }
}
