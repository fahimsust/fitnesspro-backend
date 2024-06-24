<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Dtos\CheckoutItemDto;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Illuminate\Support\Collection;

class OrderItemDtosCollection extends Collection
{
    public function offsetGet($key): OrderItemDto
    {
        return parent::offsetGet($key);
    }

    public static function fromCartItems(Collection $cartItems): static
    {
        return new static(
            $cartItems->map(
                fn(CartItem $cartItem) => OrderItemDto::fromCartItem($cartItem)
            )
        );
    }

    public static function fromCheckoutPackageModel(CheckoutPackage $package): static
    {
        return new static(
            items: $package->items->map(
                fn(CheckoutItem $item) => OrderItemDto::fromCheckoutItem($item)
            )
        );
    }
}
