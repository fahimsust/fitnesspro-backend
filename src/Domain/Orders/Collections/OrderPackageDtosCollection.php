<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Dtos\OrderPackageDto;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Illuminate\Support\Collection;

class OrderPackageDtosCollection extends Collection
{
    public function offsetGet($key): OrderPackageDto
    {
        return parent::offsetGet($key);
    }

    public static function fromCheckoutShipmentModel(
        CheckoutShipment $shipment
    ): static
    {
        return new static(
            items: $shipment->relationLoaded('packages')
                ? $shipment->packages->map(
                    fn(CheckoutPackage $package) => OrderPackageDto::fromCheckoutPackageModel(
                        $package
                    )
                )
                : null
        );
    }
}
