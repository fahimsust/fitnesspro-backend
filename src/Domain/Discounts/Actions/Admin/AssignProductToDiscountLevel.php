<?php

namespace Domain\Discounts\Actions\Admin;

use App\Api\Admin\Discounts\Requests\DiscountLevelProductRequest;
use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignProductToDiscountLevel
{
    use AsObject;

    public function handle(
        DiscountLevel $discountLevel,
        DiscountLevelProductRequest $request
    ): DiscountLevelProduct {
        if (GetProductAssignedToDiscountLevel::run($discountLevel, $request->product_id)) {
            throw new \Exception(__('Product already assigned to discount level'));
        }

        return $discountLevel->discountLevelProducts()->create(
            [
                'product_id' => $request->product_id,
            ]
        );
    }
}
