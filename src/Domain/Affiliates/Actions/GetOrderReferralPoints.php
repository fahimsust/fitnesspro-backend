<?php

namespace Domain\Affiliates\Actions;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Models\AffiliateLevel;
use Support\Contracts\AbstractAction;

class GetOrderReferralPoints extends AbstractAction
{
    public function __construct(
        public AffiliateLevel   $affiliateLevel,
    )
    {
    }

    public function execute(): int
    {
        return $this->affiliateLevel->referralPointsForOrder();
    }
}
