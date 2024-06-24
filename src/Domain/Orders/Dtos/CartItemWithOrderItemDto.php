<?php

namespace Domain\Orders\Dtos;

use Domain\Orders\Models\Carts\CartItems\CartItem;

class CartItemWithOrderItemDto
{
    public function __construct(
        public CartItem     $cartItem,
        public OrderItemDto $orderItemDto
    )
    {
    }

    public static function fromCartItem(CartItem $item): static
    {
        return new static(
            $item,
            OrderItemDto::fromCartItem($item)
        );
    }
}
