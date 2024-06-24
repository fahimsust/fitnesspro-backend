<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Contracts\ItemDto;
use Domain\Orders\Contracts\ShipmentDto;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class AssignItemDtoToShipmentDtos extends AbstractAction
{
    private int $assignedQty = 0;
    protected int $needToShipQty;

    public function __construct(
        public ItemDto    $item,
        public Collection $shipments,
    )
    {
        $this->needToShipQty = $item->cartItem->qty;
    }

    public function execute(): Collection
    {
        FindExistingShipmentDtosForItemDto::now(
            $this->item,
            $this->shipments,
        )
            ->takeUntil(
                fn(ShipmentDto $shipment) => $this->addItemToShipment($shipment)
                    && $this->needToShipQty <= $this->assignedQty
            );

        while ($this->needToShipQty > $this->assignedQty) {
            $this->createShipmentAndAddItem();
        }

        return $this->shipments;
    }

    protected function addItemToShipment(ShipmentDto $shipment): void
    {
        $assignedQty = AddItemDtoToShipmentDto::now(
            $this->item,
            $shipment,
            $this->item->product->weight() >= config('shipments.max_weight')
                ? 1
                : $this->needToShipQty - $this->assignedQty,
        );

        if ($assignedQty === 0) {
            throw new \Exception('No room left in shipment');
        }

        $this->assignedQty += $assignedQty;
    }

    protected function createShipmentAndAddItem(): void
    {
        $this->shipments->push(
            $newShipment = $this->item->createShipmentDtoWith()
        );

        $this->addItemToShipment($newShipment);
    }
}
