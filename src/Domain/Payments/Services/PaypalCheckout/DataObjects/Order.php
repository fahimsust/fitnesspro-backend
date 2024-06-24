<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Domain\Payments\Services\PaypalCheckout\Enums\PaymentIntents;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentStatuses;
use Domain\Payments\Services\PaypalCheckout\Enums\ProcessingInstructions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class Order extends Data
{
    public function __construct(
        public string                  $id,
        public PaymentStatuses         $status,
        public Collection              $links,
        public ?array                  $paymentSource,
        public ?Carbon                 $created_at = null,
        public ?Carbon                 $updated_at = null,
        public ?ProcessingInstructions $instructions = null,
        public ?Collection             $purchaseUnits = null,
        public ?PaymentIntents         $intent = null,
        public ?Payer                  $payer = null,
    )
    {
    }

    public static function fromApi(array $data)
    {
        return new self(
            id: $data['id'],
            status: PaymentStatuses::from($data['status']),
            links: collect($data['links'])
                ->mapWithKeys(fn($link) => [$link['rel'] => Link::fromApi($link)]),
            paymentSource: $data['payment_source'] ?? [],
            created_at: isset($data['create_time']) ? Carbon::parse($data['create_time']) : null,
            updated_at: isset($data['update_time']) ? Carbon::parse($data['update_time']) : null,
            instructions: isset($data['processing_instruction'])
                ? ProcessingInstructions::from($data['processing_instruction'])
                : null,
            purchaseUnits: collect($data['purchase_units'] ?? [])
                ->map(fn($unit) => PurchaseUnit::fromApi($unit)),
            intent: isset($data['intent'])
                ? PaymentIntents::from($data['intent'])
                : null,
            payer: isset($data['payer'])
                ? Payer::fromApi($data['payer'])
                : null,
        );
    }
}

/*
 * {
  "id": "5O190127TN364715T",
  "status": "PAYER_ACTION_REQUIRED",
  "payment_source": {
    "paypal": {}
  },
  "links": [
    {
      "href": "https://api-m.paypal.com/v2/checkout/orders/5O190127TN364715T",
      "rel": "self",
      "method": "GET"
    },
    {
      "href": "https://www.paypal.com/checkoutnow?token=5O190127TN364715T",
      "rel": "payer-action",
      "method": "GET"
    }
  ]
}
 */
