<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class AddDiscountToOrderItems extends AbstractAction
{
    private Collection $appliedAdvantages;

    public function __construct(
        public Discount $discount,
        public array    $orderItemIds
    ) {
        $this->appliedAdvantages = collect();
    }

    public function execute(): Collection
    {
        if (count($this->orderItemIds) == 0) {
            throw new \Exception(__('No items selected'));
        }

        OrderItem::query()
            ->with('productDetails', 'order')
            ->whereIn(
                'id',
                $this->orderItemIds
            )
            ->get()
            ->each(
                $this->applyAdvantagesToOrderItem(...)
            );

        if ($this->appliedAdvantages->isEmpty()) {
            throw new \Exception(__('Items selected do not match the selected discount'));
        }

        return $this->appliedAdvantages;
    }

    protected function applyAdvantagesToOrderItem(OrderItem $orderItem): void
    {
        $this->discount->advantages
            ->loadMissing('products', 'productTypes')
            ->each(
                function (DiscountAdvantage $advantage) use ($orderItem) {
                    $applied = ApplyDiscountAdvantageToOrderItem::run(
                        advantage: $advantage,
                        orderItem: $orderItem
                    )
                        ->logActivity()
                        ->result();

                    if (!$applied) {
                        return;
                    }

                    $this->appliedAdvantages->push($applied);
                }
            );
    }
}
