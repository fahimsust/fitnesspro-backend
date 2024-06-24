<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;

class DeleteOrderItem extends AbstractAction
{

    public function __construct(
        public OrderPackage $orderPackage,
        public OrderItem    $orderItem,
        public bool         $shouldLogActivity = false
    )
    {
    }

    public function execute(): void
    {
        DB::transaction(function () {
            $this->orderItem->options()->delete();

            ReturnOrderItemStockToInventory::now(
                $this->orderPackage,
                $this->orderItem
            );

            $this->orderItem->delete();

            if ($this->shouldLogActivity == true) {
                $this->logActivity();
            }
        });
    }

    public function logActivity()
    {
        AddOrderActivity::now(
            $this->orderItem->order,
            __(
                "Order item - Id: :item_id deleted from package - Id: :package_id",
                [
                    'item_id' => $this->orderItem->id,
                    'package_id' => $this->orderPackage->id,
                ]
            )
        );
    }
}
