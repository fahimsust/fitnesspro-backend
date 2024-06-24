<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Models\Carts\Cart;
use Support\Contracts\AbstractAction;

class CalculateRegistrationAmountDue extends AbstractAction
{
    private ?Cart $cart;

    public function __construct(
        public Registration $registration
    )
    {
    }

    public function execute(): float
    {
        if (!$this->loadCart()) {
            throw new \Exception(__("Cart is not set for registration"));
        }

        return $this->cart->total();
    }

    protected function loadCart(): Cart
    {
        return $this->cart = $this->registration->cartCached();
    }
}
