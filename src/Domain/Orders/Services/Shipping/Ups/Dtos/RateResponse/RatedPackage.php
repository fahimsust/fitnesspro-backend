<?php

namespace Domain\Orders\Services\Shipping\Ups\Dtos\RateResponse;

use Domain\Orders\Services\Shipping\Ups\Dtos\CodeWithDescription;
use Domain\Orders\Services\Shipping\Ups\Dtos\Money;
use Domain\Orders\Services\Shipping\Ups\Dtos\Weight;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class RatedPackage extends Data
{
    public function __construct(
        public ?Money               $baseServiceCharge,
        public ?Money               $transportationCharges,
        public ?Money               $serviceOptionsCharges,
        public ?Money               $totalCharges,
        public ?string              $weight,
        public ?Weight              $billingWeight,
        public Collection           $accessorial = new Collection(),
        public Collection           $itemizedCharges = new Collection(),
        public Collection           $negotiatedCharges = new Collection(),
        public ?CodeWithDescription $simpleRate = null,
        public Collection           $rateModifier = new Collection(),
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            baseServiceCharge: Money::fromApi($data['BaseServiceCharge'] ?? null),
            transportationCharges: Money::fromApi($data['TransportationCharges'] ?? null),
            serviceOptionsCharges: Money::fromApi($data['ServiceOptionsCharges'] ?? null),
            totalCharges: Money::fromApi($data['TotalCharges'] ?? null),
            weight: $data['Weight'] ?? null,
            billingWeight: Weight::fromApi($data['BillingWeight'] ?? null),
            accessorial: collect($data['Accessorial'] ?? [])
                ->map(
                    fn(array $accessorial) => CodeWithDescription::fromApi($accessorial)
                ),
            itemizedCharges: collect($data['ItemizedCharges'] ?? []),
            negotiatedCharges: collect($data['NegotiatedCharges']['ItemizedCharges'] ?? []),
            simpleRate: CodeWithDescription::fromApi($data['SimpleRate'] ?? null),
            rateModifier: collect($data['RateModifier'] ?? []),
        );
    }
}

/*
 *
  {
    "BaseServiceCharge": {
      "CurrencyCode": "str",
      "MonetaryValue": "string"
    },
    "TransportationCharges": {
      "CurrencyCode": "string",
      "MonetaryValue": "string"
    },
    "ServiceOptionsCharges": {
      "CurrencyCode": "string",
      "MonetaryValue": "string"
    },
    "TotalCharges": {
      "CurrencyCode": "string",
      "MonetaryValue": "string"
    },
    "Weight": "string",
    "BillingWeight": {
      "UnitOfMeasurement": {
        "Code": null,
        "Description": null
      },
      "Weight": "string"
    },
    "Accessorial": [
      {
        "Code": null,
        "Description": null
      }
    ],
    "ItemizedCharges": [
      {
        "Code": null,
        "Description": null,
        "CurrencyCode": null,
        "MonetaryValue": null,
        "SubType": null
      }
    ],
    "NegotiatedCharges": {
      "ItemizedCharges": [
        null
      ]
    },
    "SimpleRate": {
      "Code": "st"
    },
    "RateModifier": [
      {
        "ModifierType": null,
        "ModifierDesc": null,
        "Amount": null
      }
    ]
  }
 */
