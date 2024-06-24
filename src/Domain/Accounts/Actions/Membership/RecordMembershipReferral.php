<?php

namespace Domain\Accounts\Actions\Membership;


use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Affiliates\Actions\CreateReferralForSubscription;
use Domain\Affiliates\Models\Referral;
use Support\Contracts\AbstractAction;

class RecordMembershipReferral extends AbstractAction
{
    private ?Referral $referral = null;

    public function __construct(
        public Account      $account,
        public Subscription $subscription,
    )
    {
    }

    public function result(): ?Referral
    {
        return $this->referral;
    }

    public function execute(): static
    {
        if (!($this->account->affiliate_id > 0))
            return $this;

        $this->account->loadMissing('affiliate.level');

        return $this->createReferral()
            ->logActivity();
    }

    private function createReferral(): static
    {
        $this->referral = CreateReferralForSubscription::now(
            $this->subscription,
            $this->account->affiliate
        );

        return $this;
    }

    private function logActivity(): static
    {
        if (!$this->referral)
            return $this;

        $this->subscription->order
            ->activities()
            ->create([
                'description' => __("Affiliate referral for membership - :affiliate for :amount", [
                    'affiliate' => $this->account->affiliate->name,
                    'amount' => $this->referral->amount
                ])
            ]);

        return $this;
    }
}
