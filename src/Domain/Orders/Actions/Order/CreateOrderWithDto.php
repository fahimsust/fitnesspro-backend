<?php

namespace Domain\Orders\Actions\Order;


use Domain\Orders\Dtos\OrderDto;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class CreateOrderWithDto extends AbstractAction
{
    private Order $order;

    public function __construct(
        public OrderDto $dto
    )
    {
    }

    public function result(): Order
    {
        return $this->order;
    }

    public function execute(): static
    {
        $this->order = Order::create(
            $this->dto->toModel()
        );

        return $this;
    }
}
