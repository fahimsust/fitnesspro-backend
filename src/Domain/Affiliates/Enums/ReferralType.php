<?php

namespace Domain\Affiliates\Enums;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Models\AffiliateLevel;

enum ReferralType: int
{
    case ORDER = 1;
    case ACCOUNT = 2;
    case SUBSCRIPTION = 3;

    public function pointsByLevel(
        AffiliateLevel  $affiliateLevel,
        ?MembershipLevel $membershipLevel,
    )
    {
        return match ($this) {
            self::ORDER => $affiliateLevel->referralPointsForOrder(),
            self::SUBSCRIPTION => $affiliateLevel->referralPointsForSubscription(
                $membershipLevel
            )
        };
    }
    public function label(): string
    {
        return match ($this) {
            self::ORDER => __('Order'),
            self::ACCOUNT => __('Account'),
            self::SUBSCRIPTION => __('Subscription')
        };
    }
}
