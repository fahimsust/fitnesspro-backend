<?php

namespace App\Api\Orders\Resources\Cart;

use Domain\Orders\Models\Carts\Cart;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return ['cart' => null];
        }

        /** @var Cart $cart */
        $cart = $this->resource;

        return $cart->loadMissing([
            'items',
            'discounts',
        ])->toArray($request)
            + [
                'subtotal' => $cart->subTotal(),
                'total' => $cart->total(),
                'discount_total' => $cart->discountTotal(),
            ];
    }
}
