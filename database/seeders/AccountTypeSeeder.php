<?php

namespace Database\Seeders;

use Domain\Accounts\Models\AccountType;

class AccountTypeSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            AccountType::class,
            ['id', 'name', 'default_account_status'],
            //updated to include all account types data from live
            [
                [1, 'Standard', 1],
                [2, 'Basic', 1],
                [3, 'Enterprise', 1],
                [4, 'Medallion', 1],
                [5, 'Travel', 1],
                [6, 'Basic 30-day Trial', 1],
                [7, 'Basic - Auto Renew', 1],
                [8, 'Travel - Auto Renew', 1],
                [9, 'Medallion - Auto Renew', 1],
                [10, 'Enterprise - Auto Renew', 1],
            ]
        );
    }
}
