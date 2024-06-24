<?php

namespace Database\Seeders;

use Domain\Affiliates\Models\ReferralStatus;

class AffiliateReferralStatusSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            ReferralStatus::class,
            ['id', 'name'],
            [
                [1, 'Pending'],
                [2, 'Paid'],
                [3, 'Cancelled'],
            ]
        );
    }
}
