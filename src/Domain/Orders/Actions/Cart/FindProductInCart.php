<?php

namespace Domain\Orders\Actions\Cart;

use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class FindProductInCart
{
    use AsObject;

    private Product $product;

    public function handle(
        Cart $cart,
        Product $product
    ): Collection {
        $this->product = $product;

        return $cart->items
            ->filter(
                fn (CartItem $item) => $item->isProduct($product)
            );
    }
}
