<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Addresses\Actions\LoadAddressById;
use Domain\Orders\Exceptions\CheckoutAlreadyCompletedException;
use Domain\Orders\Models\Checkout\Checkout;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Support\Contracts\AbstractAction;

class SetCheckoutShippingAddress extends AbstractAction
{
    public function __construct(
        public Checkout $checkout,
        public int      $addressId,
        public bool     $setAsBilling = true,
    )
    {
    }

    public function execute(): Checkout
    {
        if ($this->checkout->shipping_address_id == $this->addressId) {
            return $this->checkout;
        }

        $this->validate();

        $this->checkout->update($this->updateArray());

        //delete any previously built shipments since address is changing
        $this->checkout->shipments()->delete();

        return $this->checkout;
    }

    protected function updateArray(): array
    {
        $update = [
            'shipping_address_id' => $this->addressId,
        ];

        if (!$this->setAsBilling) {
            return $update;
        }

        return $update + ['billing_address_id' => $this->addressId];
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

        if (!$accountAddress->is_shipping) {
            throw new \Exception(
                __("Address is not a shipping address.")
            );
        }

        if ($this->setAsBilling && !$accountAddress->is_billing) {
            throw new \Exception(
                __("Address is not a billing address.")
            );
        }
    }
}
