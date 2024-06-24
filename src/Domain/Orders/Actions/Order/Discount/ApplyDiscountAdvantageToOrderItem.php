<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemDiscount;
use Support\Contracts\AbstractAction;

class ApplyDiscountAdvantageToOrderItem extends AbstractAction
{
    private ?OrderItemDiscount $addedItemDiscount = null;
    private bool $shouldApply = false;

    public function __construct(
        public OrderItem         $orderItem,
        public DiscountAdvantage $advantage,
    ) {
    }

    public function execute(): static
    {
        if (!$this->shouldAdvantageApplyToItem()) {
            return $this;
        }
        if ($orderItemDiscount = $this->findDiscountApplied()) {
            $orderItemDiscount->qty = $orderItemDiscount->qty + 1;
            $orderItemDiscount->save();
            $this->addedItemDiscount = $orderItemDiscount;
        } else {
            $this->addedItemDiscount = OrderItemDiscount::create([
                'discount_id' => $this->advantage->discount_id,
                'amount' => $this->advantage->amountDisplay(),
                'advantage_id' => $this->advantage->id,
                'orders_products_id' => $this->orderItem->id,
                'qty' => 1
            ]);
        }



        return $this;
    }
    protected function findDiscountApplied()
    {
        return OrderItemDiscount::where('advantage_id', $this->advantage->id)
            ->where("orders_products_id", $this->orderItem->id)
            ->first();
    }

    protected function shouldAdvantageApplyToItem(): bool
    {
        $orderItem = $this->orderItem->load('productDetails')->first();
        return $this->shouldApply = IsAdvantageForProductType::now(
            $this->advantage,
            $orderItem->productDetails ? $orderItem->productDetails->type_id : 0
        )
            || IsAdvantageForProduct::now($this->advantage, $this->orderItem->product_id);
    }

    public function result(): ?OrderItemDiscount
    {
        return $this->addedItemDiscount;
    }

    public function logActivity(): static
    {
        if (!$this->addedItemDiscount) {
            return $this;
        }

        AddOrderActivity::now(
            $this->orderItem->order,
            __(
                "Applied discount - Id: :discount_id to order item :order_item_id; Amount: :amount; Adv Id: :advantage_id",
                [
                    'discount_id' => $this->advantage->discount_id,
                    'amount' => $this->advantage->amountDisplay(),
                    'advantage_id' => $this->advantage->id,
                    'order_item_id' => $this->orderItem->id,
                ]
            )
        );

        return $this;
    }
}
