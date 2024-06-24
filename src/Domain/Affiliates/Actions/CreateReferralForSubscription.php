<?php

namespace Domain\Affiliates\Actions;

use Domain\Accounts\Models\Membership\Subscription;
use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Support\Contracts\AbstractAction;

class CreateReferralForSubscription extends AbstractAction
{
    public function __construct(
        public Subscription $subscription,
        public Affiliate    $affiliate,
    )
    {
    }

    public function execute(): Referral
    {
        return CreateReferral::now(
            $this->affiliate,
            $this->subscription->order_id,
            ReferralType::SUBSCRIPTION,
            GetSubscriptionReferralPoints::now(
                $this->affiliate->loadMissingReturn('level'),
                $this->subscription->level,
            )
        );
    }
}
