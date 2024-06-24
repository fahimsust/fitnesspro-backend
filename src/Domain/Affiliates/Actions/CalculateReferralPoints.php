<?php

namespace Domain\Affiliates\Actions;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\Models\AffiliateLevel;
use Support\Contracts\AbstractAction;

class CalculateReferralPoints extends AbstractAction
{
    public function __construct(
        public AffiliateLevel   $affiliateLevel,
        public ReferralType     $type,
        public ?MembershipLevel $membershipLevel = null,
    )
    {
    }

    public function execute(): int
    {
        return $this->type->pointsByLevel(
            $this->affiliateLevel,
            $this->membershipLevel,
        );
    }
}
