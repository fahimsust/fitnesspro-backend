<?php

namespace App\Api\Orders\Resources\Cart;

use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Illuminate\Http\Resources\Json\JsonResource;

class CartDiscountCodeResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var CartDiscountCode $cartDiscountCode */
        $cartDiscountCode = $this->resource;

        return array_merge(
            $cartDiscountCode->only([
                'code',
            ]),
            $cartDiscountCode->discount->only([
                'id',
                'display',
            ])
        );
    }
}
