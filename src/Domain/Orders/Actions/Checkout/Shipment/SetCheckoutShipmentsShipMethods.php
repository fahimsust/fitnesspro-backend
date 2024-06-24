<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Dtos\CheckoutShipmentIdWithMethod;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;
use Symfony\Component\HttpFoundation\Response;

class SetCheckoutShipmentsShipMethods extends AbstractAction
{
    public function __construct(
        public Checkout   $checkout,
        public Collection $shipmentIdsWithMethodId,
    )
    {
    }

    public function execute(): Collection
    {
        CheckoutAlreadyCompletedException::check(
            $this->checkout
        );

        $this->checkout->shipmentsCached();

        if (
            $this->shipmentIdsWithMethodId->count() <
            $this->checkout->shipments->count()
        ) {
            throw new \Exception(
                __('Missing methods for all shipments'),
                Response::HTTP_PRECONDITION_FAILED
            );
        }

        return $this->checkout->shipments
            ->each(
                fn(CheckoutShipment $shipment) => $shipment
                    ->setRelation('checkout', $this->checkout)
            )
            ->map(
                $this->setShipmentMethod(...)
            );
    }

    protected function setShipmentMethod(
        CheckoutShipment $shipment
    ): CheckoutShipment
    {
        SetCheckoutShipmentShipMethod::now(
            $shipment,
            $this->shipmentIdsWithMethodId->firstWhere(
                fn(CheckoutShipmentIdWithMethod $shipmentMethod) => $shipmentMethod->checkoutShipmentId == $shipment->id
            )->methodId,
        );

        return $shipment;
    }
}
