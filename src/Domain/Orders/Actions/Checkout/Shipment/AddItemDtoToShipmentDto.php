<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Contracts\ItemDto;
use Domain\Orders\Contracts\PackageDto;
use Domain\Orders\Contracts\ShipmentDto;
use Support\Contracts\AbstractAction;

class AddItemDtoToShipmentDto extends AbstractAction
{
    private int $assignedQty = 0;

    public function __construct(
        public ItemDto     $item,
        public ShipmentDto $shipment,
        public int         $needToShipQty,
    )
    {
    }

    public function execute(): int
    {
        if (!$this->shipmentHasRoomForItem()) {
            return 0;
        }

        $this->shipment->packages
            ->each(
                $this->addItemToPackage(...)
            );

        if (
            !$this->moreQtyToShip()
            || !$this->shipmentHasRoomForItem()
        ) {
            return $this->assignedQty;
        }


        while ($this->moreQtyToShip() && $this->shipmentHasRoomForItem()) {
            $package = $this->item->createPackageDtoWith();
            $this->addItemToPackage($package);

            $this->shipment->packages->push($package);
        }

        return $this->assignedQty;
    }

    protected function addItemToPackage(PackageDto $package): void
    {
        $assignedQty = AddItemDtoToPackageDto::now(
            $this->item,
            $package,
            $this->shipment,
            $this->needToShipQty
        );

        $this->assignedQty += $assignedQty;
        $this->needToShipQty -= $assignedQty;
    }

    private function moreQtyToShip(): bool
    {
        return $this->needToShipQty > 0;
    }

    private function shipmentHasRoomForItem(): bool
    {
        if ($this->shipment->isDigital
            || $this->item->product->weight() <= 0) {
            return true;
        }

        return $this->shipment->hasRoom($this->item->product->weight());
    }
}
