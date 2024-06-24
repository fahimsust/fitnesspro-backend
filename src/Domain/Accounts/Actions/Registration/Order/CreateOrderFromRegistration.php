<?php

namespace Domain\Accounts\Actions\Registration\Order;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Actions\Order\CreateOrderWithDto;
use Domain\Orders\Dtos\OrderDto;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class CreateOrderFromRegistration extends AbstractAction
{
    public function __construct(
        public Registration $registration
    )
    {
    }

    public function execute(): Order
    {
        $order = CreateOrderWithDto::now(
            OrderDto::fromCartModel(
                $this->getCart(),
                $this->registration->paymentMethodCached(),
            )
        );

        $this->registration->update([
            'order_id' => $order->id,
        ]);

        return $order;
    }

    protected function getCart(): Cart
    {
        return $this->registration->cartCached()
            ?? throw new \Exception(
                __("Registration does not have a cart")
            );
    }
}
