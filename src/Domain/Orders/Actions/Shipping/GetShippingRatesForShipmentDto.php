<?php

namespace Domain\Orders\Actions\Shipping;

use Domain\Orders\Collections\CalculatedShippingRatesCollection;
use Domain\Orders\Contracts\ShipmentDto;
use Domain\Orders\Dtos\Shipping\AvailableShippingMethodDto;
use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Domain\Orders\Enums\Shipping\ShippingGateways;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;
use Support\Dtos\AddressDto;

class GetShippingRatesForShipmentDto extends AbstractAction
{
    public Collection $rates;

    public function __construct(
        public AddressDto  $address,
        public ShipmentDto $shipment,
        public ?Collection $availableMethods = null,
    )
    {
        if ($this->availableMethods === null) {
            $this->availableMethods = GetAvailableShippingMethodsForDistributors::now(
                $this->shipment->distributorId,
                $this->address,
                targetWeight: $shipment->weight(),
            );
        }

        $this->rates = new CalculatedShippingRatesCollection();
    }

    public function execute()
    {
        $this->filteredMethods()
            ->groupBy(
                fn(AvailableShippingMethodDto $method) => $method->gateway_id
            )
            ->each(
                $this->getShippingRatesForGateway(...)
            );

        $this->shipment->rates($this->rates);
    }

    protected function filteredMethods(): Collection
    {
        //double check only methods that can handle the weight
        return $this->availableMethods
            ->filter(
                fn(AvailableShippingMethodDto $method) => $method->canHandleWeight($this->shipment->weight())
            );
    }

    protected function getShippingRatesForGateway(Collection $methods, int $gatewayId)
    {
        ShippingGateways::from($gatewayId)
            ->getRates(
                $this->address,
                $this->shipment,
                $methods
            )
            ->each(
                fn(ShippingRateDto $rate) => $this->rates->push($rate)
            );
    }
}
