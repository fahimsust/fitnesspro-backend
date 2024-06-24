<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Spatie\LaravelData\Data;

class Link extends Data
{
    public function __construct(
        public string $href,
        public string $rel,
        public string $method,
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            href: $data['href'],
            rel: $data['rel'],
            method: $data['method'],
        );
    }
}

/*
  {
      "href": "https://api-m.paypal.com/v2/checkout/orders/5O190127TN364715T",
      "rel": "self",
      "method": "GET"
    }
 */
