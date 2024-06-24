<?php

namespace Domain\Discounts\Actions\Admin;

use App\Api\Admin\Discounts\Requests\DiscountLevelRequest;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Level\DiscountLevel;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateDiscountLevel
{
    use AsObject;

    public function handle(
        DiscountLevelRequest $request
    ): DiscountLevel {
        return DiscountLevel::create(
            [
                'name' => $request->name,
                'apply_to' => $request->apply_to,
                'action_type' => $request->action_type,
                'action_sitepricing' => $request->action_sitepricing,
                'action_percentage' => $request->action_percentage,
                'status' => $request->status
            ]
        );
    }
}
