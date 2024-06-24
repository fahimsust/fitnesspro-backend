<?php

namespace Domain\Orders\Actions\Order;


use Domain\Orders\Dtos\OrderDto;
use Domain\Orders\Models\Order\Order;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;

class CreateOrder extends AbstractAction
{
    private Order $order;

    public function __construct(
        public string $orderNo,
        public PaymentMethod $paymentMethod,
        public Site $site
    )
    {
    }

    public function result(): Order
    {
        return $this->order;
    }

    public function execute(): static
    {
        $this->order = CreateOrderWithDto::now(
            OrderDto::usingBasics(
                $this->orderNo,
                $this->paymentMethod,
                $this->site
            )
        );

        return $this;
    }
}
