<?php

namespace Database\Seeders;

use Domain\Orders\Models\Order\Transactions\OrderTransactionStatus;
use Illuminate\Database\Seeder;

class OrdersTransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Authorized'],
            [2,'Captured'],
            [3,'Voided'],
            [4,'Awaiting Check'],
            [5,'Awaiting Clearance'],
            [6,'Cleared']
        ];
        $fields = ['id','name'];

        foreach ($rows as $row) {
            OrderTransactionStatus::create(array_combine($fields, $row));
        }
    }
}
