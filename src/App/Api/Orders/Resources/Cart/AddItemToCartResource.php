<?php

namespace App\Api\Orders\Resources\Cart;

use App\Http\Resources\ExceptionCollectionResource;
use Domain\Orders\Actions\Cart\Item\AddItemToCartFromDto;
use Domain\Orders\Enums\Cart\CartRelations;
use Illuminate\Http\Resources\Json\JsonResource;

class AddItemToCartResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var AddItemToCartFromDto $action */
        $action = $this->resource;

        return [
            'cart' => new CartResource($action->cart->load(CartRelations::standard())),
            'item' => $action->cartItem->toArray(),
            'exceptions' => ExceptionCollectionResource::run(
                $action->exceptions(),
                $request
            ),
        ];
    }
}
