<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Collections\CheckoutShipmentDtosCollection;
use Domain\Orders\Dtos\CheckoutShipmentDto;
use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class CreateShipmentsForCheckout extends AbstractAction
{
    public Collection $shipments;

    public function __construct(
        public Checkout                        $checkout,
        public ?CheckoutShipmentDtosCollection $shipmentDtos = null,
    )
    {
        $this->shipmentDtos ??= BuildShipmentDtosFromCart::now($checkout->cartCached());
        $this->shipments = new Collection();
    }

    public function execute(): static
    {
        $this->shipmentDtos->each(
            fn(CheckoutShipmentDto $shipmentDto) => $this->shipments->push(
                CreateCheckoutShipmentFromShipmentDto::now(
                    $this->checkout,
                    $shipmentDto,
                )
            )
        );

        return $this;
    }

    public function result(): Collection
    {
        return $this->shipments;
    }

//    protected function assignModelToDto(CheckoutShipment $shipment): void
//    {
//        $dto = $this->shipmentDtos
//            ->filter(
//                fn(CheckoutShipmentDto $shipmentDto) => $shipmentDto->shipment == null
//            )
//            ->firstWhere(
//                fn(CheckoutShipmentDto $shipmentDto) => $shipmentDto->checkoutReferenceId() == $shipment->referenceId()
//            );
//
//        if ($dto) {
//            throw new \Exception('Could not find shipment dto for reference id: ' . $shipment->referenceId());
//        }
//
//        $dto->checkoutShipment = $shipment;
//    }
}
