<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Distributors\Models\Distributor;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1, 'Fit Bodies', 1, 'programming@advisiongraphics.com', '3603015898', '', 0, 0],
            [2, 'Fit Launch', 1, 'programming@advisiongraphics.com', '3603015898', 'programming@advisiongraphics.com', 1, 0]
        ];
        $fields = ['id','name','active','email','phone','account_no','is_dropshipper','inventory_account_id'];

        foreach ($rows as $row) {
            Distributor::create(array_combine($fields, $row));
        }
    }
}
