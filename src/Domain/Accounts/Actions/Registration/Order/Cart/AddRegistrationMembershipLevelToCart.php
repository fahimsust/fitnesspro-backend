<?php

namespace Domain\Accounts\Actions\Registration\Order\Cart;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Actions\Cart\Item\AddItemToCartFromDto;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Support\Contracts\AbstractAction;

class AddRegistrationMembershipLevelToCart extends AbstractAction
{
    public function __construct(
        public Registration $registration,
        public Cart         $cart
    )
    {
    }

    public function execute(): CartItem
    {
        return AddItemToCartFromDto::now(
            cart: $this->cart,
            cartItemDto: CartItemDto::fromRegistration($this->registration),
            checkAvailability: false,
            checkRequiredAccessories: false,
        );
    }
}
