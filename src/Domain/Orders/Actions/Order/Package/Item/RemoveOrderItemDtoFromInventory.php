<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use Domain\Orders\Dtos\OrderItemDto;
use Domain\Products\Actions\Product\UpdateParentStock;
use Support\Contracts\AbstractAction;

class RemoveOrderItemDtoFromInventory extends AbstractAction
{
    private bool $updated = false;

    public function __construct(
        public OrderItemDto $itemDto,
    )
    {
    }

    public function result(): bool
    {
        return $this->updated;
    }

    public function execute(): static
    {
        if(!$this->itemDto->product->inventoried)
            return $this;

        if(!$this->itemDto->productDistributor)
            return $this;
        
        $this->itemDto->productDistributor
            ->decrement('stock_qty', $this->itemDto->orderQty);

        $this->itemDto->product->setRelation(
            'parent',
            $this->itemDto->parentProduct
        );

        UpdateParentStock::run(
            $this->itemDto->product,
            $this->itemDto->orderQty,
            "decrement"
        );

        $this->updated = true;

        return $this;
    }
}
