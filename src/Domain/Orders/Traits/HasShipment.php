<?php

namespace Domain\Orders\Traits;


use Domain\Orders\Models\Order\Shipments\Shipment;

trait HasShipment
{
    public ?Shipment $shipment = null;

    public function shipment(Shipment $shipment): static
    {
        $this->shipment = $shipment;

        return $this;
    }
}
