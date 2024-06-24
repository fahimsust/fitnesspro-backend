<?php

namespace Domain\Accounts\Actions\Membership;


use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Affiliates\Actions\CreateReferral;
use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\Models\Referral;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class RewardLinkedAffiliateAccountForAutoRenewal extends AbstractAction
{
    private ?Referral $referral = null;

    public function __construct(
        public Account      $account,
        public Subscription $membership,
        public Order        $order,
    )
    {
    }

    public function result(): ?Referral
    {
        return $this->referral;
    }

    public function execute(): static
    {
        if (
            !$this->account->linkedAffiliate
            || !$this->membership->level->auto_renew_reward
        )
            return $this;

        return $this->createReferral()
            ->logActivity();
    }

    private function createReferral(): static
    {
        $this->referral = CreateReferral::now(
            $this->account->linkedAffiliate,
            $this->order->id,
            ReferralType::SUBSCRIPTION,
            $this->membership->level->auto_renew_reward
        );

        return $this;
    }

    private function logActivity(): static
    {
        if (!$this->referral)
            return $this;

        $this->order
            ->activities()
            ->create([
                'description' => __("Awarded :amount to Linked Affiliate :affiliate for auto renewal", [
                    'affiliate' => $this->account->linkedAffiliate->id,
                    'amount' => $this->referral->amount
                ])
            ]);

        return $this;
    }
}
