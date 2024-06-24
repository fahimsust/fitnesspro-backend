<?php

namespace App\Api\Orders\Controllers\Cart;

use App\Api\Orders\Resources\Cart\CartResource;
use Domain\Orders\Actions\Cart\EmptyCart;
use Domain\Orders\Enums\Cart\CartRelations;
use Support\Controllers\AbstractController;

class CartController extends AbstractController
{
    public function index()
    {
        return [
            'cart' => new CartResource(
                cart()->load(CartRelations::standard())
            ),
        ];
//
//        [
//            'items' => ['product', 'optionValues', 'customFields'],
//            'discounts' => ['advantages', 'codes']
//        ]
    }

    public function destroy()
    {
        return [
            'message' => __('Cart has been emptied'),
            'cart' => new CartResource(
                EmptyCart::run(cart())
            ),
        ];
    }
}
