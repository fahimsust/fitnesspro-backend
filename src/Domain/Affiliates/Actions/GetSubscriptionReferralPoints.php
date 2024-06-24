<?php

namespace Domain\Affiliates\Actions;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Models\AffiliateLevel;
use Support\Contracts\AbstractAction;

class GetSubscriptionReferralPoints extends AbstractAction
{
    public function __construct(
        public AffiliateLevel  $affiliateLevel,
        public MembershipLevel $membershipLevel,
    )
    {
    }

    public function execute(): int
    {
        return $this->affiliateLevel->referralPointsForSubscription(
            $this->membershipLevel
        );
    }
}
