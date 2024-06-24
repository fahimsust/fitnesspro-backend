<?php

namespace Domain\Orders\Dtos;

use Domain\Future\GiftRegistry\GiftRegistry;
use Domain\Orders\Collections\CalculatedShippingRatesCollection;
use Domain\Orders\Collections\CheckoutPackageDtosCollection;
use Domain\Orders\Contracts\ShipmentDto;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Domain\Orders\Traits\IsShipmentDto;
use Spatie\LaravelData\Data;

class CheckoutShipmentDto extends Data
    implements ShipmentDto
{
    use IsShipmentDto;

    public ?CheckoutShipment $shipment = null;

    public ?CalculatedShippingRatesCollection $rates = null;

    public function model(CheckoutShipment $model): static
    {
        $this->shipment = $model;

        return $this;
    }

    public function rates(?CalculatedShippingRatesCollection $rates): static
    {
        $this->rates = $rates;

        return $this;
    }

    public static function fromCartItemWithOrderItemDto(
        CartItemWithOrderItemDto $item,
    ): static
    {
        return new static(
            isDigital: $item->cartItem->product->isDigital(),
            distributorId: $item->orderItemDto->distributor->id,
            distributor: $item->orderItemDto->distributor,
            registry: $item->cartItem->isRegistryItem()
                ? $item->cartItem->registryItem->registry
                : null
        );
    }

    public static function fromCheckoutShipmentModel(CheckoutShipment $model): static
    {
        return (new static(
            isDigital: $model->is_digital,
            isDropShip: $model->is_drop_ship,
            shipCost: $model->shipping_cost,
            shippingMethodId: $model->shipping_method_id,
            shippingMethodLabel: $model->shippingMethodCached()?->label(),
            distributorId: $model->distributor_id,
            id: $model->id,
            packages: new CheckoutPackageDtosCollection(
                $model->loadMissingReturn('packages')->map(
                    fn(CheckoutPackage $package) => CheckoutPackageDto::fromCheckoutPackageModel(
                        $package
                    )
                )
            ),
            registry: $model->registry,
        ))
            ->model($model)
            ->rates($model->rates());
    }

    public static function withPackage(
        CheckoutPackageDto $package,
        int                $distributorId,
        bool               $isDownloads,
        ?GiftRegistry      $registry = null
    )
    {
        return new static(
            isDigital: $isDownloads,
            distributorId: $distributorId,
            packages: new CheckoutPackageDtosCollection([$package]),
            registry: $registry
        );
    }

    public function toCheckoutShipmentModel()
    {
        return [
            'distributor_id' => $this->distributorId,
            'registry_id' => $this->registry?->id,
            'shipping_method_id' => $this->shippingMethodId,
            'shipping_cost' => $this->shipCost,
            'is_drop_ship' => $this->isDropShip,
            'is_digital' => $this->isDigital,
            'latest_rates' => $this->rates,
        ];
    }

    public function checkoutReferenceId(): string
    {
        return http_build_query([
            'distributor_id' => $this->distributorId,
            'registry_id' => $this->registry?->id,
            'packages' => $this->packages->map(
                fn(CheckoutPackageDto $package) => $package->checkoutReferenceId()
            )->toArray(),
            'is_digital' => $this->isDigital,
            'is_drop_ship' => $this->isDropShip,
        ]);
    }
}
