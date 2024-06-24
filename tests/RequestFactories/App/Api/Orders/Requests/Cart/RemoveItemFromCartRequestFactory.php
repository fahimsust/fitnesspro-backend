<?php

namespace Tests\RequestFactories\App\Api\Orders\Requests\Cart;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Worksome\RequestFactories\RequestFactory;

class RemoveItemFromCartRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'cart_item_id' => CartItem::firstOrFactory()->id
        ];
    }
}
