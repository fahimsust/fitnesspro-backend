<?php

namespace Domain\Orders\Actions\Cart;

use Domain\Accounts\Actions\Registration\LoadRegistrationById;
use Domain\Orders\Models\Carts\Cart;
use Support\Contracts\AbstractAction;

class LoadCartByRegistrationId extends AbstractAction
{
    public function __construct(
        public int $registrationId,
        public bool $useCache = true
    )
    {
    }

    public function execute(): Cart
    {
        $registration = LoadRegistrationById::now(
            $this->registrationId,
            $this->useCache
        );

        if (!$this->useCache) {
            return $registration->loadMissing('cart')->cart;
        }

        return $registration->cartCached();
    }
}
