<?php

namespace Domain\Orders\Services\Shipping\Ups\Actions;

use Domain\Orders\Services\Shipping\Ups\Client;
use Domain\Orders\Services\Shipping\Ups\Dtos\RateResponse\RateResponse;
use Domain\Orders\Services\Shipping\Ups\Enums\PackageTypes;
use Domain\Orders\Services\Shipping\Ups\Enums\RateTypes;
use Support\Contracts\AbstractAction;
use Support\Dtos\AddressDto;

class GetRates extends AbstractAction
{
    public function __construct(
        public Client       $client,
        public RateTypes    $rateType,
        public string       $upsAccountNumber,
        public AddressDto   $shipFrom,
        public AddressDto   $shipTo,
        public float        $packageWeight,
        public PackageTypes $packageType = PackageTypes::Package,
        public string       $version = "v1"
    )
    {
    }

    public function execute(): RateResponse
    {
        return RateResponse::fromApi(
            $this->client
                ->post(
                    uri: "api/rating/{$this->version}/{$this->rateType->value}",
                    data: [
                        'RateRequest' => [
                            'Request' => [
                                'RequestOption' => $this->rateType->value
                            ],
                            'Shipment' => [
                                'Shipper' => [
                                    'ShipperNumber' => $this->upsAccountNumber,
                                    'Address' => [
                                        'AddressLine' => $this->shipFrom->address_1,
                                        'City' => $this->shipFrom->city,
                                        'StateProvinceCode' => $this->shipFrom->stateAbbreviation,
                                        'PostalCode' => $this->shipFrom->postal_code,
                                        'CountryCode' => $this->shipFrom->countryAbbreviation,
                                    ],
                                ],
                                'ShipTo' => [
                                    'Address' => [
                                        'AddressLine' => $this->shipTo->address_1,
                                        'City' => $this->shipTo->city,
                                        'StateProvinceCode' => $this->shipTo->stateAbbreviation,
                                        'PostalCode' => $this->shipTo->postal_code,
                                        'CountryCode' => $this->shipTo->countryAbbreviation,
                                    ],
                                ],
                                'Package' => [
                                    'PackagingType' => [
                                        'Code' => $this->packageType->value,
                                    ],
                                    'PackageWeight' => [
                                        'UnitOfMeasurement' => [
                                            'Code' => 'Lbs',
                                            'Description' => 'Pounds',
                                        ],
                                        'Weight' => (string)ceil($this->packageWeight),
                                    ],
                                ],
                                'ShipmentRatingOptions' => [
                                    'NegotiatedRatesIndicator' => '',
                                ],
                            ],
                        ]
                    ]
                )
                ->json()
        );
    }
}
