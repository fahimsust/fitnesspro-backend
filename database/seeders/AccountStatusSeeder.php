<?php

namespace Database\Seeders;

use Domain\Accounts\Models\AccountStatus;

class AccountStatusSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            AccountStatus::class,
            ['id', 'name'],
            [
                [1, 'Active'],
                [2, 'Deactivated'],
                [3, 'Awaiting Approval'],
                [4, 'Awaiting Payment for Subscription Membership'],
                [5, 'Deleted'],
                [6, 'Awaiting Email Verification'],
            ]
        );
    }
}
