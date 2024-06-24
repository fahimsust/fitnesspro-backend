<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountUsedDiscount;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderDiscount;
use Support\Contracts\AbstractAction;

class RemoveDiscountFromOrder extends AbstractAction
{
    public function __construct(
        public Order $order,
        public Discount $discount,
        public ?Account $account = null,
    ) {
    }

    public function execute(): void
    {
        OrderDiscount::where('order_id', $this->order->id)
            ->where('discount_id', $this->discount->id)
            ->delete();

        AddOrderActivity::now($this->order, "Remove discount - Id: " . $this->discount->id);

        if ($this->account) {
            AccountUsedDiscount::where('order_id', $this->order->id)
                ->where('discount_id', $this->discount->id)
                ->delete();
        }
    }
}
