<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Dtos\CheckoutShipmentDto;
use Domain\Orders\Dtos\OrderShipmentDto;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Illuminate\Support\Collection;

class OrderShipmentDtosCollection extends Collection
{
    public function offsetGet($key): OrderShipmentDto
    {
        return parent::offsetGet($key);
    }

    public static function fromCheckoutShipmentDtos(
        Collection $checkoutShipmentDtos
    ): static
    {
        return new static(
            items: $checkoutShipmentDtos->map(
                fn(CheckoutShipmentDto $dto) => OrderShipmentDto::fromCheckoutShipmentDto(
                    $dto
                )
            )
        );
    }

    public static function fromCheckoutModel(
        Checkout $checkout
    ): static
    {
        return new static(
            items: $checkout->relationLoaded('shipments')
                ? $checkout->shipments->map(
                    fn(CheckoutShipment $shipment) => OrderShipmentDto::fromCheckoutShipmentModel(
                        $shipment
                    )
                        ->order($checkout->order)
                )
                : null
        );
    }
}
