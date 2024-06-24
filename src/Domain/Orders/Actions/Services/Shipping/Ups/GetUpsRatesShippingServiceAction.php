<?php

namespace Domain\Orders\Actions\Services\Shipping\Ups;

use Domain\Distributors\Models\Shipping\DistributorUps;
use Domain\Orders\Contracts\ShippingServiceAction;
use Domain\Orders\Contracts\ShippingServiceModel;
use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Domain\Orders\Services\Shipping\Ups\Actions\GetRates;
use Domain\Orders\Services\Shipping\Ups\Dtos\RateResponse\RatedShipment;
use Domain\Orders\Services\Shipping\Ups\Enums\Regions;
use Illuminate\Support\Collection;
use Support\Dtos\AddressDto;

class GetUpsRatesShippingServiceAction extends ShippingServiceAction
{
    private AddressDto $fromAddress;

    public ShippingServiceModel|DistributorUps $serviceModel;

    public function getRates(): Collection
    {
        $this->prepAddresses();

        return GetRates::now(
            client: $this->serviceModel->client(),
            rateType: $this->serviceModel->rateType(),
            upsAccountNumber: $this->serviceModel->getCredential('ups_account_number'),
            shipFrom: $this->fromAddress,
            shipTo: $this->address,
            packageWeight: $this->shipment->weight(),
        )
            ->ratedShipments
            ->map(
                $this->buildCalculatedRate(...)
            );
    }

    protected function buildCalculatedRate(RatedShipment $shipment): ShippingRateDto
    {
        return new ShippingRateDto(
            reference_name: $shipment->service->code,
            price: $shipment->totalCharges->amount,
            display: $shipment->serviceLabel(
                from: Regions::fromCountry($this->fromAddress->countryAbbreviation),
                to: Regions::fromCountry($this->address->countryAbbreviation),
            ),
        );
    }

    private function prepAddresses(): void
    {
        $this->address
            ->loadState()
            ->loadCountry();

        $this->fromAddress = AddressDto::fromModel(
            $this->serviceModel->addressCached()
        )
            ->loadState()
            ->loadCountry();
    }
}
