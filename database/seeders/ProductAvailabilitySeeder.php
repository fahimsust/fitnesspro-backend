<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Products\Models\Product\ProductAvailability;

class ProductAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'In Stock',NULL,4.00,NULL,1],
            [2,'Out of Stock',NULL,NULL,0.00,1],
            [3,'On Order',NULL,NULL,NULL,0],
            [4,'Discontinued',NULL,NULL,NULL,0],
            [5,'Low Stock',NULL,1.00,3.00,1]
        ];
        $fields = ['id','name','display','qty_min','qty_max','auto_adjust'];

        foreach ($rows as $row) {
            ProductAvailability::create(array_combine($fields, $row));
        }
    }
}
