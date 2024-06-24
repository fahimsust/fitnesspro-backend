<?php

namespace Domain\Orders\Dtos;

use Domain\Orders\Collections\OrderItemDtosCollection;
use Domain\Orders\Contracts\ItemDto;
use Domain\Orders\Contracts\PackageDto;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Spatie\LaravelData\Data;

class OrderPackageDto extends Data
    implements PackageDto
{
    public ?Shipment $orderShipment = null;

    public float $weight = 0;

    public function __construct(
        public ?OrderItemDtosCollection $items = new OrderItemDtosCollection(),
    )
    {
    }

    public static function fromCheckoutPackageModel(CheckoutPackage $package): static
    {
        return new static(
            items: $package->relationLoaded('items')
                ? OrderItemDtosCollection::fromCheckoutPackageModel($package)
                : null
        );
    }

    public static function withItem(OrderItemDto $itemDto): static
    {
        return (new static())
            ->addItem($itemDto);
    }

    public function addItem(OrderItemDto|ItemDto $itemDto): static
    {
        $this->items->push($itemDto);

        if ($itemDto->product->isDigital()) {
            return $this;
        }

        $this->weight = bcadd(
            $this->weight,
            bcmul($itemDto->product->weight(), $itemDto->orderQty),
        );

        return $this;
    }

    public function shipment(Shipment $shipment): static
    {
        $this->orderShipment = $shipment;

        return $this;
    }

    public function toPackageModel(): array
    {
        return [
            'shipment_id' => $this->orderShipment->id
        ];
    }

    public function weight(): float
    {
        return $this->items->reduce(
            fn(?float $carry, OrderItemDto $item) => bcadd(
                $carry,
                bcmul($item->product->weight(), $item->orderQty),
            ),
            0
        );
    }
}
