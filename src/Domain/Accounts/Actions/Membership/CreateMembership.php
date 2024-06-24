<?php

namespace Domain\Accounts\Actions\Membership;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Affiliates\Actions\CreateReferralForSubscription;
use Domain\Affiliates\Models\Referral;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateMembership
{
    use AsObject;

    public Subscription|Model|null $subscription = null;
    public ?Referral $referral = null;

    public function handle(
        Account $account,
        array   $subscriptionData
    ): static
    {
        $this->subscription = $account
            ->memberships()
            ->create($subscriptionData);

        if ($account->affiliate_id > 0) {
            $this->referral = CreateReferralForSubscription::run(
                $this->subscription,
                $account->loadMissingReturn('affiliate')
            );
        }

        return $this;
    }
}
