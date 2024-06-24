<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderDiscount;
use Support\Contracts\AbstractAction;

class ApplyDiscountAdvantageToOrder extends AbstractAction
{
    private int $discountId;
    private ?OrderDiscount $addedAdvantage = null;

    public function __construct(
        public Order             $order,
        public DiscountAdvantage $advantage,
        public ?Account          $account = null,
    )
    {
        $this->discountId = $advantage->discount_id;
    }

    public function execute(): static
    {
        if (!IsOrderAdvantage::now($this->advantage)) {
            return $this;
        }

        $this->addedAdvantage = OrderDiscount::create([
            'order_id' => $this->order->id,
            'discount_id' => $this->discountId,
            'amount' => $this->advantage->amountDisplay(),
            'advantage_id' => $this->advantage->id,
        ]);

        return $this;
    }

    public function result(): ?OrderDiscount
    {
        return $this->addedAdvantage;
    }

    public function logActivity(): static
    {
        AddOrderActivity::now(
            $this->order,
            __(
                "Applied order discount - Id: :discount_id; Amount: :amount; Adv Id: :advantage_id",
                [
                    'discount_id' => $this->discountId,
                    'amount' => $this->advantage->amountDisplay(),
                    'advantage_id' => $this->advantage->id,
                ]
            )
        );
        return $this;
    }
}
