<?php

namespace Domain\Orders\Actions\Order\Shipment;

use Domain\Distributors\Models\Distributor;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Support\Contracts\AbstractAction;

class UpdateShipment extends AbstractAction
{

    public function __construct(
        public Shipment $shipment,
        public Order    $order,
        public          $data
    ) {
    }

    public function execute(): void
    {
        $this->shipment->update((array)$this->data);

        $updated = [];

        if (isset($this->data->ship_cost)) {
            $updated[] = "ship cost changed to " . $this->data->ship_cost;
        }

        if (isset($this->data->distributor_id)) {
            $distributor = Distributor::select('id', 'name')
                ->find($this->data->distributor_id);
            $updated[] = "distributor changed to $distributor->name";
        }

        if (isset($this->data->order_status_id)) {
            $shipmentStatus = ShipmentStatus::select('id', 'name')
                ->find($this->data->order_status_id);
            $updated[] = "status changed to $shipmentStatus->name";
        }

        $description = "Shipment {$this->shipment->id} updated: " .
            implode('\n - ', $updated);

        AddOrderActivity::now($this->order, $description);
    }
}
