<?php

namespace Domain\Orders\Actions\Order\Shipment;

use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Actions\Order\Package\DeleteOrderPackage;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;

class DeleteShipment extends AbstractAction
{
    public function __construct(
        public Shipment $shipment,
        public Order    $order,
        public bool     $shouldLogActivity = false
    )
    {
    }

    public function execute(): void
    {
        DB::transaction(function () {
            foreach ($this->shipment->packages as $package) {
                DeleteOrderPackage::now(
                    $package,
                    $this->shipment,
                    $this->shouldLogActivity
                );
            }

            if ($this->shouldLogActivity == true) {
                $this->logActivity();
            }

            $this->shipment->delete();
        });
    }

    public function logActivity()
    {
        AddOrderActivity::now(
            $this->shipment->order,
            __(
                "Shipment - Id: :shipment_id deleted from Order",
                [
                    'shipment_id' => $this->shipment->id,
                ]
            )
        );
    }
}
