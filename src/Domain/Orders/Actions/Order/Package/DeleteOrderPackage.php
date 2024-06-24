<?php

namespace Domain\Orders\Actions\Order\Package;

use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Actions\Order\Package\Item\DeleteOrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Support\Contracts\ActionWithLogMsg;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;

class DeleteOrderPackage extends AbstractAction
    implements ActionWithLogMsg
{
    public function __construct(
        public OrderPackage $orderPackage,
        public Shipment     $shipment,
        public bool         $shouldLogActivity = false
    )
    {
    }

    public function execute(): static
    {
        DB::transaction(function () {
            $this->orderPackage
                ->items
                ->loadMissing('product', 'parentProduct')
                ->each(
                    fn(OrderItem $item) => DeleteOrderItem::now($this->orderPackage, $item)
                );

            $this->orderPackage->delete();

            if (!$this->shouldLogActivity) {
                return;
            }

            AddOrderActivity::now(
                $this->shipment->order,
                $this->logMsg()
            );
        });

        return $this;
    }

    public function logMsg(): string
    {
        return __(
            "Order Package :package_id deleted from Shipment :shipment_id",
            [
                'package_id' => $this->orderPackage->id,
                'shipment_id' => $this->shipment->id
            ]
        );
    }
}
