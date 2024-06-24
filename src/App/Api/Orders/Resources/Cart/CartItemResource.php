<?php

namespace App\Api\Orders\Resources\Cart;

use Domain\Orders\Enums\Cart\CartItemRelations;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var CartItem $cartItem */
        $cartItem = $this->resource;

        return $cartItem
            ->load(CartItemRelations::standard())
            ->toArray();
    }
}
