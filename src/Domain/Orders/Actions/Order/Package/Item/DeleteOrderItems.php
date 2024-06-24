<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;

class DeleteOrderItems extends AbstractAction
{

    public function __construct(
        public OrderPackage $orderPackage,
        public array   $items
    )
    {
    }

    public function execute(): void
    {
        DB::transaction(function () {
            foreach($this->items as $item)
            {
                DeleteOrderItem::now($this->orderPackage,OrderItem::find($item), true);
            }
        });
    }
}
