<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Actions\Shipping\LoadShippingMethodById;
use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Support\Contracts\AbstractAction;

class SetCheckoutShipmentShipMethod extends AbstractAction
{
    public function __construct(
        public CheckoutShipment $shipment,
        public int              $methodId,
        public ?float           $shippingCost = null,
    )
    {
    }

    public function execute(): CheckoutShipment
    {
        CheckoutAlreadyCompletedException::check(
            $this->shipment->checkoutCached()
        );
        LoadShippingMethodById::now($this->methodId);

        $this->shipment->update([
            'shipping_method_id' => $this->methodId,
            'shipping_cost' => $this->getShippingCost(),
        ]);

        return $this->shipment;
    }

    protected function getShippingCost(): ?float
    {
        return $this->shippingCost
            ?? $this->shipment->rates()
                ->firstWhere(
                    fn(ShippingRateDto $rate) => $rate->id == $this->methodId
                )
                ?->price;
    }
}
