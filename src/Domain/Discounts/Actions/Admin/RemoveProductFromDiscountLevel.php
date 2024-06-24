<?php

namespace Domain\Discounts\Actions\Admin;

use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveProductFromDiscountLevel
{
    use AsObject;

    public function handle(
        DiscountLevel $discountLevel,
        int $productId
    ): Product {
        if (!GetProductAssignedToDiscountLevel::run($discountLevel, $productId)) {
            throw new \Exception(__('Product not assigned to discount level'));
        }

        $discountLevel->discountLevelProducts()->whereProductId($productId)->delete();

        return Product::find($productId, ['title']);
    }
}
