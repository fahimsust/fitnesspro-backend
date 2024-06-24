<?php

namespace Domain\Discounts\Actions\Admin;

use App\Api\Admin\Discounts\Requests\DiscountRequest;
use Domain\Discounts\Models\Discount;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateDiscount
{
    use AsObject;

    public function handle(
        Discount $discount,
        DiscountRequest $request
    ): Discount {

        $discount->update(
            [
                'name' => $request->name,
                'display' => $request->display,
                'start_date' => $request->start_date,
                'exp_date' => $request->exp_date,
                'limit_uses' => $request->limit_uses,
                'limit_per_order' => $request->limit_per_order,
                'limit_per_customer' => $request->limit_per_customer,

            ]
        );

        return $discount;
    }
}
