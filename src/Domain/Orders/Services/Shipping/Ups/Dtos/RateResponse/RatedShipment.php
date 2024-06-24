<?php

namespace Domain\Orders\Services\Shipping\Ups\Dtos\RateResponse;

use Domain\Orders\Services\Shipping\Ups\Dtos\CodeWithDescription;
use Domain\Orders\Services\Shipping\Ups\Dtos\Money;
use Domain\Orders\Services\Shipping\Ups\Dtos\Weight;
use Domain\Orders\Services\Shipping\Ups\Enums\Regions;
use Domain\Orders\Services\Shipping\Ups\Enums\ServiceCodes;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class RatedShipment extends Data
{
    public function __construct(
        public CodeWithDescription     $service,
        public Weight                  $billingWeight,
        public Money                   $transportationCharges,
        public Money                   $serviceOptionsCharges,
        public Money                   $totalCharges,
        public Collection|RatedPackage $ratedPackage,
        public ?string                 $rateChart,
        public ?string                 $billableWeightCalculationMethod,
        public ?string                 $ratingMethod,
        public ?array                  $baseServiceCharge,
        public ?array                  $itemizedCharges,
        public ?array                  $fRSShipmentData,
        public ?array                  $taxCharges,
        public ?array                  $totalChargesWithTaxes,
        public ?array                  $negotiatedRateCharges,
        public ?array                  $timeInTransit,
        public ?string                 $scheduledDeliveryDate,
        public ?string                 $roarRatedIndicator,
        public Collection              $disclaimer = new Collection(),
        public Collection              $ratedShipmentAlert = new Collection(),
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            service: CodeWithDescription::fromApi($data['Service']),
            billingWeight: Weight::fromApi($data['BillingWeight']),
            transportationCharges: Money::fromApi($data['TransportationCharges']),
            serviceOptionsCharges: Money::fromApi($data['ServiceOptionsCharges']),
            totalCharges: Money::fromApi($data['TotalCharges']),
            ratedPackage: isset($data['RatedPackage'][0])
                ? collect($data['RatedPackage'])
                    ->map(
                        fn(array $ratedPackage) => RatedPackage::fromApi($ratedPackage)
                    )
                : RatedPackage::fromApi($data['RatedPackage']),
            rateChart: $data['RateChart'] ?? null,
            billableWeightCalculationMethod: $data['BillableWeightCalculationMethod'] ?? null,
            ratingMethod: $data['RatingMethod'] ?? null,
            baseServiceCharge: $data['BaseServiceCharge'] ?? null,
            itemizedCharges: $data['ItemizedCharges'] ?? null,
            fRSShipmentData: $data['FRSShipmentData'] ?? null,
            taxCharges: $data['TaxCharges'] ?? null,
            totalChargesWithTaxes: $data['TotalChargesWithTaxes'] ?? null,
            negotiatedRateCharges: $data['NegotiatedRateCharges'] ?? null,
            timeInTransit: $data['TimeInTransit'] ?? null,
            scheduledDeliveryDate: $data['ScheduledDeliveryDate'] ?? null,
            roarRatedIndicator: $data['RoarRatedIndicator'] ?? null,
            disclaimer: collect($data['Disclaimer'] ?? [])
                ->map(
                    fn(array $disclaimer) => CodeWithDescription::fromApi($disclaimer)
                ),
            ratedShipmentAlert: collect($data['RatedShipmentAlert'] ?? [])
                ->map(
                    fn(array $ratedShipmentAlert) => CodeWithDescription::fromApi($ratedShipmentAlert)
                ),
        );
    }

    public function serviceLabel(Regions $from, Regions $to): string
    {
        return ServiceCodes::from($this->service->code)
            ->label($from, $to);
    }
}

/*
 *
      {
        "Disclaimer": [
          {
            "Code": "st",
            "Description": "string"
          }
        ],
        "Service": {
          "Code": "str",
          "Description": "string"
        },
        "RateChart": "s",
        "RatedShipmentAlert": [
          {
            "Code": "string",
            "Description": "string"
          }
        ],
        "BillableWeightCalculationMethod": "st",
        "RatingMethod": "st",
        "BillingWeight": {
          "UnitOfMeasurement": {
            "Code": "str",
            "Description": "string"
          },
          "Weight": "strin"
        },
        "TransportationCharges": {
          "CurrencyCode": "str",
          "MonetaryValue": "stringstringstri"
        },
        "BaseServiceCharge": {
          "CurrencyCode": "str",
          "MonetaryValue": "stringstringstri"
        },
        "ItemizedCharges": [
          {
            "Code": "str",
            "Description": "string",
            "CurrencyCode": "str",
            "MonetaryValue": "string",
            "SubType": "string"
          }
        ],
        "FRSShipmentData": {
          "TransportationCharges": {
            "GrossCharge": {
              "CurrencyCode": "str",
              "MonetaryValue": "string"
            },
            "DiscountAmount": {
              "CurrencyCode": "str",
              "MonetaryValue": "string"
            },
            "DiscountPercentage": "st",
            "NetCharge": {
              "CurrencyCode": "str",
              "MonetaryValue": "string"
            }
          },
          "FreightDensityRate": {
            "Density": "strin",
            "TotalCubicFeet": "string"
          },
          "HandlingUnits": [
            {
              "Quantity": "string",
              "Type": {
                "Code": null,
                "Description": null
              },
              "Dimensions": {
                "UnitOfMeasurement": null,
                "Length": null,
                "Width": null,
                "Height": null
              },
              "AdjustedHeight": {
                "Value": null,
                "UnitOfMeasurement": null
              }
            }
          ]
        },
        "ServiceOptionsCharges": {
          "CurrencyCode": "str",
          "MonetaryValue": "string"
        },
        "TaxCharges": [
          {
            "Type": "string",
            "MonetaryValue": "string"
          }
        ],
        "TotalCharges": {
          "CurrencyCode": "str",
          "MonetaryValue": "string"
        },
        "TotalChargesWithTaxes": {
          "CurrencyCode": "str",
          "MonetaryValue": "string"
        },
        "NegotiatedRateCharges": {
          "ItemizedCharges": [
            {
              "Code": "str",
              "Description": "string",
              "CurrencyCode": "str",
              "MonetaryValue": "string",
              "SubType": "string"
            }
          ],
          "TaxCharges": [
            {
              "Type": "string",
              "MonetaryValue": "string"
            }
          ],
          "TotalCharge": {
            "CurrencyCode": "string",
            "MonetaryValue": "string"
          },
          "TotalChargesWithTaxes": {
            "CurrencyCode": "string",
            "MonetaryValue": "string"
          }
        },
        "RatedPackage": [
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
        ],
        "TimeInTransit": {
          "PickupDate": "stringst",
          "DocumentsOnlyIndicator": "string",
          "PackageBillType": "st",
          "ServiceSummary": {
            "Service": {
              "Description": "string"
            },
            "GuaranteedIndicator": "string",
            "Disclaimer": "string",
            "EstimatedArrival": {
              "Arrival": {
                "Date": null,
                "Time": null
              },
              "BusinessDaysInTransit": "strin",
              "Pickup": {
                "Date": null,
                "Time": null
              },
              "DayOfWeek": "string",
              "CustomerCenterCutoff": "string",
              "DelayCount": "str",
              "HolidayCount": "st",
              "RestDays": "st",
              "TotalTransitDays": "strin"
            },
            "SaturdayDelivery": "string",
            "SaturdayDeliveryDisclaimer": "string",
            "SundayDelivery": "string",
            "SundayDeliveryDisclaimer": "string"
          },
          "AutoDutyCode": "st",
          "Disclaimer": "string"
        },
        "ScheduledDeliveryDate": "string",
        "RoarRatedIndicator": "string"
      }
 */
