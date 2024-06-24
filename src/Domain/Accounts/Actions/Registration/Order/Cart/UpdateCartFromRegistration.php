<?php

namespace Domain\Accounts\Actions\Registration\Order\Cart;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Support\Contracts\AbstractAction;
use Support\Traits\ActionExecuteReturnsStatic;

class UpdateCartFromRegistration extends AbstractAction
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
        if (!$this->registration->cart_id) {
            throw new \Exception(
                __("Registration does not have a cart")
            );
        }

        $this->cart = $this->registration->cartCached();

        $this->cart->items()->delete();
        $this->cart->clearCaches();

        $this->addedItem = AddRegistrationMembershipLevelToCart::now(
            $this->registration,
            $this->cart
        );

        $this->registration
            ->setRelation('cart', $this->cart);

        return $this;
    }
}
