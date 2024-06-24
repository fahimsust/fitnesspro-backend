<?php

namespace Domain\Orders\Actions\Order\Shipment;

use App\Api\Admin\Orders\Requests\CreateShipmentRequest;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class AddShipment extends AbstractAction
{

    public function __construct(
        public Order                 $order,
        public CreateShipmentRequest $request,
    )
    {
    }

    public function execute(): Shipment|Model
    {
        $shipment = $this->order->shipments()
            ->create($this->request->all());

        $shipmentStatus = GetDefaultStatus::now();
        if($shipmentStatus)
        {
            $shipment->update(['order_status_id'=>$shipmentStatus->id]);
        }
        $shipment->packages()->create();

        AddOrderActivity::now(
            $this->order,
            "Shipment Id {$shipment->id} created"
        );

        return $shipment;
    }
}
