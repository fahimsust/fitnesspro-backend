<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use App\Api\Admin\Orders\Requests\AddProductToOrderPackageRequest;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Support\Contracts\ActionWithLogMsg;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class AddProductToOrderPackage extends AbstractAction
    implements ActionWithLogMsg
{

    public OrderItem|Model $createdOrderItem;
    private Order $order;
    private Shipment $shipment;
    private OrderItemDto $orderItemDto;

    public function __construct(
        public OrderPackage               $orderPackage,
        public AddProductToOrderPackageRequest $request
    )
    {
        $this->shipment = $orderPackage->shipment;
        $this->order = $orderPackage->shipment->order;
    }

    public function execute(): static
    {
        $this->orderItemDto = (new LoadProductWithEntitiesActionForOrderItem(
            $this->request->child_product_id,
            $this->order->site,
        ))
            ->overrideDistributorId($this->shipment->distributor_id)
            ->execute()
            ->toOrderItemDto(
                $this->request->qty,
                $this->request->option_custom_values,
                $this->request->custom_field_values,
                $this->request->accessories,
            );

        $this->createdOrderItem = AddItemToOrderPackageFromDto::now(
            $this->shipment,
            $this->orderPackage,
            $this->orderItemDto,
        );

        AddOrderActivity::now(
            $this->order,
            $this->logMsg()
        );

        return $this;
    }

    public function logMsg(): string
    {
        return __("New Item :item_id added to Package :package_id", [
            'item_id' => $this->createdOrderItem->id,
            'package_id' => $this->orderPackage->id
        ]);
    }
}
