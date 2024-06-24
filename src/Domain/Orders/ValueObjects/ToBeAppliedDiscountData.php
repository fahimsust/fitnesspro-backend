<?php

namespace Domain\Orders\ValueObjects;

use Domain\Discounts\Models\Discount;
use Spatie\LaravelData\Data;

class ToBeAppliedDiscountData extends Data
{
    public function __construct(
        public Discount $discount,
        public int $countToApply = 1
    ) {
    }
}
