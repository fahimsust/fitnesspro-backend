<?php

namespace Domain\Discounts\Actions\Admin;

use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductAssignedToDiscountLevel
{
    use AsObject;

    public function handle(
        DiscountLevel $discountLevel,
        int $product_id,
    ): ?DiscountLevelProduct {
        return $discountLevel->discountLevelProducts()->whereProductId($product_id)->first();
    }
}
