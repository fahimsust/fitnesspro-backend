<?php

namespace Domain\Accounts\Actions\Membership;

use Domain\Accounts\Models\Membership\Subscription;
use Domain\Accounts\Models\Registration\Registration;
use Support\Contracts\AbstractAction;

class CreateMembershipFromRegistration extends AbstractAction
{
    public function __construct(
        public Registration $registration,
        public float        $amountPaid,
        public float        $subscriptionPrice,
    )
    {
    }

    public function execute(): Subscription
    {
        return CreateMembership::run(
            $this->registration->accountCached(),
            [
                'level_id' => $this->registration->level_id,
                'amount_paid' => $this->amountPaid,
                'start_date' => now()->format('Y-m-d H:i:s'),
                'end_date' => now()->addYear()->format('Y-m-d H:i:s'),
                'subscription_price' => $this->subscriptionPrice,
                'product_id' => $this->registration->levelCached()->annual_product_id,
                'order_id' => $this->registration->order_id,
            ]
        )->subscription;
    }
}
