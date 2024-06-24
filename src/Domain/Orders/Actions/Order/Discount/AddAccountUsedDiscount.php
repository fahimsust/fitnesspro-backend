<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Accounts\Models\AccountUsedDiscount;
use Domain\Discounts\Models\Discount;
use Support\Contracts\AbstractAction;

class AddAccountUsedDiscount extends AbstractAction
{

    public function __construct(
        public Discount         $discount,
        public int               $orderId,
        public ?int              $accountId = null,
        public int               $timesUsed = 1
    ) {
    }

    public function execute(): AccountUsedDiscount
    {
        return AccountUsedDiscount::create([
            'order_id' => $this->orderId,
            'discount_id' => $this->discount->id,
            'times_used' => $this->timesUsed,
            'account_id' => $this->accountId
        ]);
    }
}
