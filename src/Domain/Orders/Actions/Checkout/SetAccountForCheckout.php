<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Accounts\Actions\LoadAccountByIdFromCache;
use Domain\Orders\Exceptions\AccountNotAllowedCheckoutException;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\Checkout;
use Support\Contracts\AbstractAction;

class SetAccountForCheckout extends AbstractAction
{
    public function __construct(
        public Checkout $checkout,
        public int      $accountId,
    )
    {
    }

    public function execute(): Checkout
    {
        if($this->checkout->account_id == $this->accountId) {
            return $this->checkout;
        }

        CheckoutAlreadyCompletedException::check($this->checkout);
        AccountNotAllowedCheckoutException::check(
            LoadAccountByIdFromCache::now(
                $this->accountId
            )
        );

        $this->checkout->update([
            'account_id' => $this->accountId,
            'billing_address_id' => null,
            'shipping_address_id' => null,
            'payment_method_id' => null,
        ]);

        //delete any previously built shipments since address is changing
        $this->checkout->shipments()->delete();

        return $this->checkout;
    }
}
