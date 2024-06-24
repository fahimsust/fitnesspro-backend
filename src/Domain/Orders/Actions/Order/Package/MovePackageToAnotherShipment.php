<?php

namespace Domain\Orders\Actions\Order\Package;

use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Support\Contracts\ActionWithLogMsg;
use Support\Contracts\AbstractAction;

class MovePackageToAnotherShipment extends AbstractAction
    implements ActionWithLogMsg
{
    public function __construct(
        public OrderPackage $orderPackage,
        public Shipment     $currentShipment,
        public Shipment     $moveToShipment,
    )
    {
    }

    public function execute(): static
    {
        if ($this->currentShipment->distributor_id != $this->moveToShipment->distributor_id) {
            throw new \Exception(__('Shipment distributor mismatch'));
        }

        $this->orderPackage->update(['shipment_id' => $this->moveToShipment->id]);

        AddOrderActivity::now(
            $this->currentShipment->loadMissingReturn('order'),
            $this->logMsg()
        );

        return $this;
    }

    public function logMsg(): string
    {
        return __("Package :package_id moved from shipment :shipment_id to :new_shipment_id", [
            'package_id' => $this->orderPackage->id,
            'shipment_id' => $this->currentShipment->id,
            'new_shipment_id' => $this->moveToShipment->id
        ]);
    }
}
