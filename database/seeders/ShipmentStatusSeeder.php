<?php

namespace Database\Seeders;

use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Illuminate\Database\Seeder;

class ShipmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [15, 'Pending', 0],
            [1, 'Processing', 1],
            [2, 'Awaiting Label', 65],
            [3, 'Ready to Print', 65],
            [4, 'Ready to Ship', 65],
            [5, 'Shipped', 20],
            [6, 'Completed', 100],
            [7, 'Cancelled', 12],
            [8, 'Sent to Dropshipper', 30],
            [9, 'Awaiting Payment', 35],
            [10, 'Confirmed', 7],
            [11, 'Backordered', 100],
            [12, 'Awaiting Resolution', 9],
            [13, 'Cancelled with Credit', 10],
            [14, 'Invoiced', 100],
        ];
        $fields = ['id', 'name', 'rank'];

        foreach ($rows as $row) {
            ShipmentStatus::create(array_combine($fields, $row));
        }
    }
}
