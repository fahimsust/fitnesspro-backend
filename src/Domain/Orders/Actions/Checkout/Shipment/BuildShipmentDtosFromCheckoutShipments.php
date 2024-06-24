<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Dtos\CheckoutShipmentDto;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class BuildShipmentDtosFromCheckoutShipments extends AbstractAction
{

    public function __construct(
        public Collection $checkoutShipments
    )
    {
    }

    public function execute(): Collection
    {
        return $this->checkoutShipments->map(
            fn(CheckoutShipment $shipment) => CheckoutShipmentDto::fromCheckoutShipmentModel(
                $shipment
            )
        );
    }
}
