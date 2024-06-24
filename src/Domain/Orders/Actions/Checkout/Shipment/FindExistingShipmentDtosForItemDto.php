<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Contracts\ItemDto;
use Domain\Orders\Contracts\ShipmentDto;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class FindExistingShipmentDtosForItemDto extends AbstractAction
{

    public function __construct(
        public ItemDto    $item,
        public Collection $shipments,
    )
    {
    }

    public function execute(): Collection
    {
        return $this->shipments->filter(
            $this->matchItemWithShipment(...)
        );
    }

    protected function matchItemWithShipment(ShipmentDto $shipment): bool
    {
        return $this->matchDistributor($shipment)
            && $this->matchIsDigital($shipment)
            && $this->matchRegistryCriteria($shipment)
            && $this->shipmentHasRoomForItem($shipment);
    }

    private function matchDistributor(ShipmentDto $shipment): bool
    {
        return $shipment->distributorId === $this->item->distributor->id;
    }

    private function matchIsDigital(ShipmentDto $shipment): bool
    {
        return $shipment->isDigital === $this->item->product->isDigital();
    }

    private function matchRegistryCriteria(ShipmentDto $shipment): bool
    {
        return (!$shipment->isRegistryShipment() && !$this->item->cartItem->isRegistryItem()
            || $shipment->registry->id === $this->item->cartItem->registryItem->registry_id);
    }

    private function shipmentHasRoomForItem(ShipmentDto $shipment): bool
    {
        return $shipment->hasRoom($this->item->product->weight());
    }
}
