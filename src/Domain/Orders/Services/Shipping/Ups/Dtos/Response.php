<?php

namespace Domain\Orders\Services\Shipping\Ups\Dtos;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class Response extends Data
{
    public function __construct(
        public CodeWithDescription $status,
        public Collection          $alert,
        public ?array              $alertDetail,
        public array|string|null   $transactionReference,
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            status: CodeWithDescription::fromApi($data['ResponseStatus']),
            alert: collect($data['Alert'])
                ->map(
                    fn(array $alert) => CodeWithDescription::fromApi($alert)
                ),
            alertDetail: $data['AlertDetail'] ?? null,
            transactionReference: $data['TransactionReference'] ?? null,
        );
    }
}

/*
 * {
      "ResponseStatus": {
        "Code": "s",
        "Description": "string"
      },
      "Alert": [
        {
          "Code": "string",
          "Description": "string"
        }
      ],
      "AlertDetail": [
        {
          "Code": "string",
          "Description": "string",
          "ElementLevelInformation": {
            "Level": "s",
            "ElementIdentifier": [
              {
                "Code": null,
                "Value": null
              }
            ]
          }
        }
      ],
      "TransactionReference": {
        "CustomerContext": "string"
      }
}
 */
