<?php

namespace Domain\Orders\Actions\Shipping;

use Domain\Orders\Contracts\ShipmentDto;
use Domain\Orders\Dtos\Shipping\AvailableShippingMethodDto;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;
use Support\Dtos\AddressDto;

class CalculateShippingRatesForShipmentDtos extends AbstractAction
{
    private Collection $availableMethods;

    public function __construct(
        public AddressDto $address,
        public Collection $shipments,
    )
    {
    }

    public function execute()
    {
        $this->availableMethods = GetAvailableShippingMethodsForDistributors::now(
            $this->shipments
                ->map(
                    fn(ShipmentDto $shipment) => $shipment->distributorId
                )
                ->toArray(),
            $this->address
        );

        return $this->shipments->each(
            $this->getShippingRates(...)
        );
    }

    protected function getShippingRates(ShipmentDto $shipment)
    {
        GetShippingRatesForShipmentDto::now(
            $this->address,
            $shipment,
            $this->availableMethods->filter(
                fn(AvailableShippingMethodDto $method) => $method->distributor_id === $shipment->distributorId
            )
        );
    }
}
