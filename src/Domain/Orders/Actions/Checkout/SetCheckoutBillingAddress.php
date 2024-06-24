<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Addresses\Actions\LoadAddressById;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Support\Contracts\AbstractAction;

class SetCheckoutBillingAddress extends AbstractAction
{
    public function __construct(
        public Checkout $checkout,
        public int      $addressId,
    )
    {
    }

    public function execute(): Checkout
    {
        if($this->checkout->billing_address_id == $this->addressId) {
            return $this->checkout;
        }

        $this->validate();

        $this->checkout->update([
            'billing_address_id' => $this->addressId,
        ]);

        return $this->checkout;
    }

    protected function validate(): void
    {
        CheckoutAlreadyCompletedException::check($this->checkout);

        $accountAddress = $this->checkout->accountCached()
            ->addresses()
            ->where('address_id', $this->addressId)
            ->first()
            ?? throw new ModelNotFoundException(
                __("Address does not belong to account.")
            );

        if (!$accountAddress->is_billing) {
            throw new \Exception(
                __("Address is not a billing address.")
            );
        }
    }
}
