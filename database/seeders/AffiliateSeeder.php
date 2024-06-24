<?php

namespace Database\Seeders;

use Domain\Accounts\Models\Account;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\AffiliateLevel;
use Domain\Affiliates\Models\ReferralStatus;

class AffiliateSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $affiliateLevels = AffiliateLevel::all();
        foreach ($affiliateLevels as $affiliateLevel) {
            $account = Account::factory()->create();
            Affiliate::factory(10)->create(['affiliate_level_id' => $affiliateLevel->id, 'account_id' => $account->id]);
        }
    }
}
