<?php

namespace Domain\Accounts\Actions\Registration\Order\Cart;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Dtos\CartDto;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Support\Contracts\AbstractAction;
use Support\Traits\ActionExecuteReturnsStatic;

class StartCartFromRegistration extends AbstractAction
{
    use ActionExecuteReturnsStatic;

    private Cart $cart;
    private CartItem $addedItem;

    public function __construct(
        public Registration $registration,
    )
    {
    }

    public function result(): Cart
    {
        return $this->cart;
    }

    public function execute(): static
    {
        if ($this->registration->cart_id > 0) {
            throw new \Exception(
                __("Registration already has a cart")
            );
        }

        $this->addedItem = AddRegistrationMembershipLevelToCart::now(
            $this->registration,
            $this->createCart()
        );

        $this->registration
            ->setRelation('cart', $this->cart)
            ->update([
                'cart_id' => $this->cart->id,
            ]);

        return $this;
    }

    private function createCart(): Cart
    {
        return $this->cart = CartDto::fromRegistration($this->registration)
            ->toModel();
    }
}
