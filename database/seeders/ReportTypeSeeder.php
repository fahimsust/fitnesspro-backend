<?php

namespace Database\Seeders;

use Domain\Reports\Models\ReportType;
use Illuminate\Database\Seeder;

class ReportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1, 'Orders - Sales'],
            [2, 'Orders - Taxes'],
            [3, 'Orders - Shipping'],
            [4, 'Orders - Discounts'],
            [5, 'Products - Bestsellers'],
            [6, 'Products - Most Viewed'],
            [7, 'Products - Low Stock'],
            [8, 'Customers - Accounts'],
            [9, 'Customers - Orders'],
            [10, 'Searches'],
            [12, 'Products - Details'],
        ];
        $fields = ['id', 'name'];

        foreach ($rows as $row) {
            ReportType::create(array_combine($fields, $row));
        }
    }
}
