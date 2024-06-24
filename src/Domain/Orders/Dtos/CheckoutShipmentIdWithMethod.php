<?php

namespace Domain\Orders\Dtos;

use Spatie\LaravelData\Data;

class CheckoutShipmentIdWithMethod extends Data
{
    public function __construct(
        public int $checkoutShipmentId,
        public int $methodId,
    )
    {
    }
}
