<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Contracts\ItemDto;
use Domain\Orders\Contracts\PackageDto;
use Domain\Orders\Contracts\ShipmentDto;
use Support\Contracts\AbstractAction;

class AddItemDtoToPackageDto extends AbstractAction
{
    private int $roomLeftInQty;

    public function __construct(
        public ItemDto     $item,
        public PackageDto  $package,
        public ShipmentDto $shipment,
        public int         $needToShipQty,
    )
    {
        $this->calculateRoomLeft();
    }

    public function execute(): int
    {
        if ($this->roomLeftInQty <= 0) {
            return 0;
        }

        $assignedQty = min($this->needToShipQty, $this->roomLeftInQty);

        $packageItem = clone($this->item);
        $packageItem->orderQty = $assignedQty;

        $this->package->addItem($packageItem);

        return $assignedQty;
    }

    private function calculateRoomLeft(): void
    {
        if ($this->shipment->isDigital
            || $this->item->product->weight() <= 0) {
            $this->roomLeftInQty = $this->needToShipQty;

            return;
        }

        if (
            $this->item->product->weight() >= config('shipments.max_package_weight')
            && $this->package->items->isEmpty()
        ) {
            $this->roomLeftInQty = 1;

            return;
        }

        if (!$this->shipment->hasRoom($this->item->product->weight())) {
            $this->roomLeftInQty = 0;

            return;
        }

        $roomLeftInWeight = bcsub(config('shipments.max_package_weight'), $this->package->weight());
        if ($this->shipment->roomLeftInWeight() < $roomLeftInWeight) {//if shipment has less room than max package weight
            $roomLeftInWeight = $this->shipment->roomLeftInWeight();
        }

        $this->roomLeftInQty = floor(bcdiv($roomLeftInWeight, $this->item->product->weight()));
    }
}
