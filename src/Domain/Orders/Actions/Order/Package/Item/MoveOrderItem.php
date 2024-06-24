<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use App\Api\Admin\Orders\Requests\MoveOrderItemRequest;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Support\Contracts\AbstractAction;

class MoveOrderItem extends AbstractAction
{
    public function __construct(
        public OrderPackage $orderPackage,
        public OrderItem $orderItem,
        public MoveOrderItemRequest $request
    ) {
    }

    public function execute(): void
    {
        $orderPackageUpdated = OrderPackage::find($this->request->package_id);
        if ($this->orderPackage->shipment->distributor_id != $orderPackageUpdated->shipment->distributor_id) {
            throw new \Exception(__('Package distributor miss match'));
        }
        $this->orderItem->update(['package_id' => $this->request->package_id]);
        AddOrderActivity::now(
            $this->orderPackage->shipment->order,
            __(
                "Order Item - Id: :item_id moved from package - Id: package_id to package - Id:new_package_id",
                [
                    'item_id' => $this->orderItem->id,
                    'package_id' => $this->orderPackage->id,
                    'new_package_id' => $this->request->package_id,
                ]
            )
        );
    }
}
