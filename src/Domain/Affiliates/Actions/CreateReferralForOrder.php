<?php

namespace Domain\Affiliates\Actions;

use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class CreateReferralForOrder extends AbstractAction
{
    public function __construct(
        public Order     $order,
        public Affiliate $affiliate,
    ) {
    }

    public function execute(): Referral
    {
        $this->order->update([
            'affiliate_id' => $this->affiliate->id,
        ]);
        return CreateReferral::now(
            $this->affiliate,
            $this->order->id,
            ReferralType::ORDER,
            GetOrderReferralPoints::now(
                $this->affiliate->loadMissingReturn('level'),
            )
        );
    }
}
