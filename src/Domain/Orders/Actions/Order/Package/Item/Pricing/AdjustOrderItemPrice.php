<?php

namespace Domain\Orders\Actions\Order\Package\Item\Pricing;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\AbstractAction;
use Support\Enums\AmountAdjustmentTypes;

class AdjustOrderItemPrice extends AbstractAction
{
    public function __construct(
        public OrderItem $item,
        public int $adjustmentAmount,
        public AmountAdjustmentTypes $type
    )
    {
    }

    public function execute(
    ) {
        if ($this->adjustmentAmount === 0) {
            return;
        }

        $this->item->update([
            'price_reg' => $this->type->adjustAmount($this->adjustmentAmount, $this->item->price_reg),
            'price_sale' => $this->type->adjustAmount($this->adjustmentAmount, $this->item->price_sale),
        ]);
    }
}
