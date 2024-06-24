<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Discounts\Models\Discount;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemDiscount;
use Support\Contracts\AbstractAction;

class RemoveDiscountFromOrderItem extends AbstractAction
{
    public function __construct(
        public OrderItem $orderItem,
        public Discount $discount,
    ) {
    }

    public function execute(): void
    {
        OrderItemDiscount::where('orders_products_id', $this->orderItem->id)
            ->where('discount_id', $this->discount->id)
            ->delete();

        AddOrderActivity::now(
            $this->orderItem->order,
            __(
                "Discount - Id: discount_id removed from item - Id: item_id",
                [
                    'discount_id' => $this->discount->id,
                    'item_id' => $this->orderItem->id,
                ]
            )
        );
    }
}
