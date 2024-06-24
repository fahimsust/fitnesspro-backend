<?php

namespace Domain\Orders\Actions\Order\Shipment;

use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Support\Contracts\ActionWithLogMsg;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class AddPackageToShipment extends AbstractAction
    implements ActionWithLogMsg
{
    public OrderPackage|Model $createdPackage;

    public function __construct(
        public Shipment $shipment,
    ) {
    }

    public function execute(): static
    {
        $this->createdPackage = $this->shipment->packages()->create();

        AddOrderActivity::now(
            $this->shipment->order,
            $this->logMsg()
        );

        return $this;
    }

    public function logMsg(): string
    {
        return __(
            "New Package :package_id added to Shipment :shipment_id",
            [
                'package_id' => $this->createdPackage->id,
                'shipment_id' => $this->shipment->id
            ]
        );
    }
}
