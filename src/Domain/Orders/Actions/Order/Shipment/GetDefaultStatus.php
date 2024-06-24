<?php

namespace Domain\Orders\Actions\Order\Shipment;

use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Support\Contracts\AbstractAction;

class GetDefaultStatus extends AbstractAction
{

    public function __construct(
    )
    {
    }

    public function execute()
    {
        $shipmentStatus = ShipmentStatus::orderBy('rank','ASC')->first();
        if($shipmentStatus)
        {
            return $shipmentStatus;
        }

        return false;
    }
}
