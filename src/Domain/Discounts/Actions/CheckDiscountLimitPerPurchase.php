<?php

namespace Domain\Discounts\Actions;

use Domain\Discounts\Models\Discount;
use Domain\Orders\ValueObjects\ToBeAppliedDiscountData;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckDiscountLimitPerPurchase
{
    use AsObject;

    public function handle(
        Discount $discount,
        int $alreadyAppliedCount = 0
    ): ToBeAppliedDiscountData {
        $limit = $discount->limit_per_order ?: 1000;

        if ($limit <= $alreadyAppliedCount) {
            throw new \Exception(
                __("Discount :display has reached it's limit of :limit", [
                    'display' => $discount->display,
                    'limit' => $limit,
                ])
            );
        }

        return new ToBeAppliedDiscountData(
            $discount,
            $limit - $alreadyAppliedCount
        );
    }
}
