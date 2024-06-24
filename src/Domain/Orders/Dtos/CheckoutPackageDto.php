<?php

namespace Domain\Orders\Dtos;

use Domain\Orders\Collections\CheckoutItemDtosCollection;
use Domain\Orders\Contracts\ItemDto;
use Domain\Orders\Contracts\PackageDto;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Spatie\LaravelData\Data;

class CheckoutPackageDto extends Data
    implements PackageDto
{
    public ?CheckoutShipment $shipment = null;

    public ?CheckoutPackage $checkoutPackage = null;

    public float $weight = 0;

    public function __construct(
        public ?CheckoutItemDtosCollection $items = new CheckoutItemDtosCollection(),
    )
    {
    }

    public function checkoutShipment(
        CheckoutShipment $shipment
    ): static
    {
        $this->shipment = $shipment;

        return $this;
    }

    public static function fromCheckoutPackageModel(CheckoutPackage $model): static
    {
        $model->loadMissing('items');

        return static::from([
                'items' => CheckoutItemDtosCollection::fromCheckoutPackageModel($model),
                'package' => $model,
            ]
        );
    }

    public static function withItem(CheckoutItemDto $itemDto): static
    {
        return (new static())
            ->addItem($itemDto);
    }

    public function addItem(CheckoutItemDto|ItemDto $itemDto): static
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

    public function toPackageModel(): array
    {
        return [
            'shipment_id' => $this->shipment->id
        ];
    }

    public function checkoutReferenceId(): string
    {
        return http_build_query([
            'items' => $this->items->map(
                fn(CheckoutItemDto $item) => $item->checkoutReferenceId()
            )->toArray(),
        ]);
    }

    public function weight(): float
    {
        return $this->items->reduce(
            fn(?float $carry, CheckoutItemDto $item) => bcadd(
                $carry,
                bcmul($item->product->weight(), $item->orderQty),
            ),
            0
        );
    }
}
