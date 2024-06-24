<?php

namespace Database\Seeders;

use Domain\Modules\Models\ModuleAdminController;
use Illuminate\Database\Seeder;

class ModuleAdminControllerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1, 49, 'customer_account_edit'],
            [3, 50, 'customer_account_edit'],
            [4, 50, 'lobby'],
            [5, 63, 'customer_account_edit'],
            [6, 69, 'lobby'],
            [7, 69, 'customer_account_edit'],
            [8, 69, 'orders_edit'],
            [9, 36, 'lobby'],
        ];
        $fields = ['id', 'module_id', 'controller_section'];

        foreach ($rows as $row) {
            ModuleAdminController::create(array_combine($fields, $row));
        }
    }
}
