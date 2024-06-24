<?php

namespace Domain\Discounts\Actions;

use Domain\Discounts\Models\Discount;
use Lorisleiva\Actions\Concerns\AsObject;

class FindDiscountByCode
{
    use AsObject;

    public function handle(string $discountCode): Discount
    {
        return FindDiscountConditionByCode::run($discountCode)
            ->rule
            ->discount;
    }
}
