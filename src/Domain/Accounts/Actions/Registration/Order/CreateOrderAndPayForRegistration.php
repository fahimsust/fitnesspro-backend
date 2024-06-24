<?php

namespace Domain\Accounts\Actions\Registration\Order;

use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Support\Contracts\AbstractAction;
use Support\Dtos\RedirectUrl;

class CreateOrderAndPayForRegistration extends AbstractAction
{
    private Order $order;

    private Cart $cart;

    public function __construct(
        public Registration   $registration,
        public PaymentRequest $paymentRequest,
    )
    {
    }

    public function execute(): OrderTransaction|RedirectUrl|true
    {
        return $this
            ->loadEntitiesFromRegistration()
            ->loadOrCreateOrder()
            ->makePayment();
    }

    protected function loadEntitiesFromRegistration(): static
    {
        $this->cart = $this->registration->cartCached()
            ?? throw new \Exception(
                __("Registration does not have a cart")
            );

        $this->cart->itemsCached();

        return $this;
    }

    protected function loadOrCreateOrder(): static
    {
        if ($this->registration->order_id) {
            $this->order = $this->registration->orderCached();

            return $this;
        }

        $this->order = CreateOrderFromRegistration::now(
            $this->registration
        );

        return $this;
    }

    protected function makePayment(): OrderTransaction|RedirectUrl|true
    {
        $amount = $this->cart->total();

        if ($amount <= 0) {
            return true;
        }

        return PayForRegistration::now(
            $this->order,
            $this->registration,
            $this->paymentRequest,
            $amount,
        );
    }
}
