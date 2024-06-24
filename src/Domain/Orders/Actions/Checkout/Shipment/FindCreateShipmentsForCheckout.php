<?php

namespace Domain\Orders\Actions\Checkout\Shipment;

use Domain\Orders\Collections\CheckoutShipmentDtosCollection;
use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class FindCreateShipmentsForCheckout extends AbstractAction
{
    public Collection $shipments;

    public function __construct(
        public Checkout                        $checkout,
        public ?CheckoutShipmentDtosCollection $shipmentDtos = null,
    )
    {
        $this->shipmentDtos ??= BuildShipmentDtosFromCart::now($checkout->cartCached());
    }

    public function execute(): Collection
    {
        //todo improve matching (perhaps by checkoutReferenceId i started on)

        if ($this->checkout->shipments->count() == $this->shipmentDtos->count()) {
            return $this->checkout->shipments;
        }

        if ($this->checkout->shipments->count() > 0) {//count mismatch, delete existing shipments
            $this->checkout->shipments()->delete();
        }

        return CreateShipmentsForCheckout::now($this->checkout);
    }
}
