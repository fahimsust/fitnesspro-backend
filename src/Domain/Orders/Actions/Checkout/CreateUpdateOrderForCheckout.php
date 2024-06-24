<?php

namespace Domain\Orders\Actions\Checkout;

use Domain\Orders\Actions\Order\CreateOrderWithDto;
use Domain\Orders\Actions\Order\UpdateOrderWithDto;
use Domain\Orders\Dtos\OrderDto;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class CreateUpdateOrderForCheckout extends AbstractAction
{
    public function __construct(
        public Checkout $checkout
    )
    {
    }

    public function execute(): Order
    {
        if ($this->checkout->order_id > 0) {
            return UpdateOrderWithDto::now(
                $this->checkout->orderCached(),
                OrderDto::fromCheckoutModel($this->checkout)
            );;
        }

        $order = CreateOrderWithDto::now(
            OrderDto::fromCheckoutModel($this->checkout)
        );

        $this->checkout->update([
            'order_id' => $order->id,
        ]);

        return $order;
    }
}
