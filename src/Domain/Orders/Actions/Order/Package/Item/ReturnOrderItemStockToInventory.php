<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Products\Actions\LoadProductDistributorByIds;
use Domain\Products\Actions\Product\UpdateParentStock;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;

class ReturnOrderItemStockToInventory extends AbstractAction
{
    private bool $updated = false;

    public function __construct(
        public OrderPackage $package,
        public OrderItem    $orderItem
    )
    {
    }

    public function execute(): static
    {
        return DB::transaction(function () {
            $this->orderItem->setRelation('package', $this->package);

            if (!$this->orderItem->product->inventoried) {
                return $this;
            }

            $productDistributor = LoadProductDistributorByIds::now(
                $this->orderItem->product_id,
                $this->package->shipment->distributor_id
            );

            if (!$productDistributor) {
                return $this;
            }

            $productDistributor->increment(
                'stock_qty',
                $this->orderItem->product_qty
            );

            $this->orderItem->product->setRelation(
                'parent',
                $this->orderItem->parentProduct
            );

            UpdateParentStock::run(
                $this->orderItem->product,
                $this->orderItem->product_qty
            );

            $this->updated = true;

            return $this;
        });
    }

    public function result(): bool
    {
        return $this->updated;
    }
}
