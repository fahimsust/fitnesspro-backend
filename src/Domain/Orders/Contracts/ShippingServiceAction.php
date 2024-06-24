<?php

namespace Domain\Orders\Contracts;

use Domain\Orders\Dtos\Shipping\AvailableShippingMethodDto;
use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;
use Support\Dtos\AddressDto;

abstract class ShippingServiceAction extends AbstractAction
{
    public function __construct(
        public ShippingServiceModel $serviceModel,
        public AddressDto           $address,
        public ShipmentDto          $shipment,
        public Collection           $availableMethods,
    )
    {
    }

    public function execute(): Collection
    {
        return $this->getRates()
            ->filter(
                $this->matchCalculatedRateToShippingMethod(...)
            )
            ->map(
                $this->normalizeRate(...)
            );
    }

    protected function matchCalculatedRateToShippingMethod(
        ShippingRateDto $rate,
    ): bool
    {
        $method = $this->availableMethods->firstWhere(
            fn(AvailableShippingMethodDto $method) => $method->reference_name == $rate->reference_name
        );

        if (!$method) {
            return false;
        }

        $rate->shippingMethodDto = $method;

        return true;
    }

    protected function normalizeRate(ShippingRateDto $rate): ShippingRateDto
    {
        $rate->id = $rate->shippingMethodDto->id;
        $rate->name = $rate->shippingMethodDto->name;
        $rate->display = $rate->shippingMethodDto->display;
        $rate->callForEstimate = $rate->shippingMethodDto->call_for_estimate;

        return $rate->finalizePrice();
    }

    abstract public function getRates(): Collection;
}
