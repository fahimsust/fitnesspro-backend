<?php

namespace Domain\Discounts\Actions\Admin;

use App\Api\Admin\Discounts\Requests\DiscountRequest;
use Domain\Discounts\Models\Discount;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateDiscount
{
    use AsObject;

    public function handle(
        DiscountRequest $request
    ): Discount {
        return Discount::create(
            [
                'name' => $request->name,
                'display' => $request->display,
                'start_date' => $request->start_date,
                'exp_date' => $request->exp_date,
                'limit_uses' => $request->limit_uses?$request->limit_uses:0,
                'limit_per_order' => $request->limit_per_order?$request->limit_per_order:0,
                'limit_per_customer' => $request->limit_per_customer?$request->limit_per_customer:0,
            ]
        );
    }
}
