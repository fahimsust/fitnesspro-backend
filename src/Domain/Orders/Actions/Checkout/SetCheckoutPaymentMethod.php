<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Payments\Actions\LoadPaymentOptionForSite;
use Support\Contracts\AbstractAction;

class SetCheckoutPaymentMethod extends AbstractAction
{
    public function __construct(
        public Checkout $checkout,
        public int      $methodId,
    )
    {
    }

    public function execute(): Checkout
    {
        if ($this->checkout->payment_method_id == $this->methodId) {
            return $this->checkout;
        }

        CheckoutAlreadyCompletedException::check($this->checkout);

        LoadPaymentOptionForSite::now(
            $this->checkout->siteCached(),
            $this->methodId
        );

        $this->checkout->update(
            ['payment_method_id' => $this->methodId]
        );

        return $this->checkout;
    }
}
